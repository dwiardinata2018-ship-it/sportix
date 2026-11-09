<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\BlockedSlot;
use App\Models\OperatingHour;
use App\Models\PricingRule;
use App\Models\Venue;
use App\Models\VenueUnit;
use Carbon\Carbon;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'venue',
            'unit',
            'paymentRecord',
            'review',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.booking.index', compact('bookings'));
    }


        public function qr(int $id)
        {
            // Ambil booking milik User yang sedang login.
            $booking = Booking::with([
                'venue',
                'unit',
                'paymentRecord',
            ])
                ->where('user_id', auth()->id())
                ->where('id', $id)
                ->firstOrFail();

            // Pastikan booking sudah dikonfirmasi.
            if ($booking->booking_status !== 'confirmed') {
                return redirect()
                    ->route('user.booking')
                    ->with('error', 'QR Check-in hanya tersedia untuk booking yang sudah dikonfirmasi.');
            }

            // Pastikan pembayaran sudah berhasil.
            if (
                !$booking->paymentRecord ||
                $booking->paymentRecord->payment_status !== 'paid'
            ) {
                return redirect()
                    ->route('user.booking')
                    ->with('error', 'QR Check-in belum tersedia. Silakan selesaikan pembayaran terlebih dahulu.');
            }

            // Buat token berdasarkan booking code.
            $checkinToken = hash_hmac(
                'sha256',
                $booking->booking_code,
                config('app.key')
            );

            // Buat hash token.
            $tokenHash = hash('sha256', $checkinToken);

            // Simpan hash jika booking lama belum memiliki token.
            if (empty($booking->checkin_token_hash)) {
                $booking->checkin_token_hash = $tokenHash;
                $booking->save();
            }

            // Pastikan token cocok dengan hash di database.
            if (!hash_equals(
                $booking->checkin_token_hash,
                $tokenHash
            )) {
                abort(403, 'Token QR tidak valid.');
            }

            // Generate QR Code dalam format SVG.
            $qrCode = QrCode::format('svg')
                ->size(250)
                ->margin(2)
                ->generate($checkinToken);

            return view('user.booking.qr', compact('booking', 'qrCode'));
        }

    /**
     * Memproses pemesanan venue oleh User.
     */
   public function store(StoreBookingRequest $request)
    {
        // 1. Validasi data yang dikirim User.
        $validated = $request->validated();

        // 2. Jalankan proses booking dalam transaksi database.
        $booking = DB::transaction(function () use ($validated, $request) {

            // Kunci unit agar proses booking pada unit yang sama
            // berjalan secara bergantian.
            $unit = VenueUnit::where('id', $validated['unit_id'])
                ->where('venue_id', $validated['venue_id'])
                ->lockForUpdate()
                ->first();

            if (!$unit || !$unit->is_active) {
                throw ValidationException::withMessages([
                    'unit_id' => 'Unit tidak ditemukan atau sedang tidak aktif.',
                ]);
            }

            // 3. Periksa venue.
            $venue = Venue::where('id', $validated['venue_id'])
                ->where('verification_status', 'verified')
                ->where('venue_status', 'active')
                ->first();

            if (!$venue) {
                throw ValidationException::withMessages([
                    'venue_id' => 'Venue tidak tersedia untuk pemesanan.',
                ]);
            }

            // 4. Siapkan tanggal dan waktu.
            $date = $validated['date'];
            $startTime = $validated['start_time'];
            $endTime = $validated['end_time'];

            $weekday = Carbon::parse($date)->dayOfWeekIso;

            $startAt = Carbon::parse("$date $startTime");
            $endAt = Carbon::parse("$date $endTime");

            // Cegah pemesanan pada waktu yang sudah lewat.
            if ($startAt->lte(now())) {
                throw ValidationException::withMessages([
                    'start_time' => 'Waktu pemesanan harus lebih besar dari waktu sekarang.',
                ]);
            }

            $durationMinutes = $startAt->diffInMinutes($endAt);

            // 5. Periksa jam operasional venue.
            $operatingHour = $venue->operatingHours()
                ->where('weekday', $weekday)
                ->first();

            if (
                !$operatingHour ||
                $operatingHour->is_closed ||
                $startTime < substr($operatingHour->open_time, 0, 5) ||
                $endTime > substr($operatingHour->close_time, 0, 5)
            ) {
                throw ValidationException::withMessages([
                    'start_time' => 'Waktu pemesanan berada di luar jam operasional venue.',
                ]);
            }

            // 6. Periksa jadwal yang diblokir Owner.
            $isBlocked = BlockedSlot::where('unit_id', $unit->id)
                ->where('start_at', '<', $endAt)
                ->where('end_at', '>', $startAt)
                ->exists();

            if ($isBlocked) {
                throw ValidationException::withMessages([
                    'unit_id' => 'Unit sedang diblokir pada waktu tersebut.',
                ]);
            }

            // 7. Periksa booking yang bertabrakan.
            $currentTime = now();

            $hasBooking = Booking::where('unit_id', $unit->id)
                ->whereDate('booking_date', $date)
                ->where('start_time', '<', $endTime)
                ->where('end_time', '>', $startTime)
                ->where(function ($query) use ($currentTime) {
                    $query->whereIn('booking_status', [
                        'confirmed',
                        'checked_in',
                    ])
                    ->orWhere(function ($pendingQuery) use ($currentTime) {
                        $pendingQuery
                            ->where('booking_status', 'pending_confirmation')
                            ->where(function ($expiryQuery) use ($currentTime) {
                                $expiryQuery
                                    ->whereNull('expires_at')
                                    ->orWhere('expires_at', '>', $currentTime);
                            });
                    });
                })
                ->exists();

            if ($hasBooking) {
                throw ValidationException::withMessages([
                    'unit_id' => 'Maaf, unit sudah dipesan pada waktu tersebut.',
                ]);
            }

            // 8. Cari aturan harga yang sesuai.
            $pricingRule = PricingRule::where('venue_id', $venue->id)
                ->where(function ($query) use ($unit) {
                    $query->where('unit_id', $unit->id)
                        ->orWhereNull('unit_id');
                })
                ->where(function ($query) use ($weekday) {
                    $query->where('weekday', $weekday)
                        ->orWhereNull('weekday');
                })
                ->where(function ($query) use ($date) {
                    $query->whereNull('effective_from')
                        ->orWhereDate('effective_from', '<=', $date);
                })
                ->where(function ($query) use ($date) {
                    $query->whereNull('effective_until')
                        ->orWhereDate('effective_until', '>=', $date);
                })
                ->where('is_active', true)
                ->where('start_time', '<=', $startTime)
                ->where('end_time', '>=', $endTime)
                ->orderByRaw('unit_id IS NULL ASC')
                ->orderByRaw('weekday IS NULL ASC')
                ->first();

            if (!$pricingRule) {
                throw ValidationException::withMessages([
                    'start_time' => 'Aturan harga tidak ditemukan untuk waktu tersebut.',
                ]);
            }

            // 9. Hitung total harga.
            $pricePerHour = (float) $pricingRule->price_per_hour;

            $totalPrice = round(
                ($pricePerHour / 60) * $durationMinutes,
                2
            );

            // 10. Siapkan token QR Check-in.
            $bookingCode = 'SPX-' . strtoupper(Str::random(12));

            $checkinToken = hash_hmac(
                'sha256',
                $bookingCode,
                config('app.key')
            );

            // 11. Simpan booking baru.
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => $request->user()->id,
                'venue_id' => $venue->id,
                'unit_id' => $unit->id,
                'booking_date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'duration_minutes' => $durationMinutes,
                'price_per_hour_snapshot' => $pricePerHour,
                'total_price' => $totalPrice,
                'booking_status' => 'pending_confirmation',
                'checkin_token_hash' => hash('sha256', $checkinToken),
                'user_notes' => $validated['user_notes'] ?? null,
            ]);

            // 11. Catat riwayat status pertama.
            BookingStatusHistory::create([
                'booking_id' => $booking->id,
                'changed_by' => $request->user()->id,
                'old_status' => null,
                'new_status' => 'pending_confirmation',
                'notes' => 'Booking baru dibuat oleh User.',
            ]);

            return $booking;
        }, 3);

        // 12. Berikan informasi keberhasilan kepada User.
        return redirect()
            ->route('user.booking')
            ->with('success', 'Booking berhasil dibuat dengan kode: ' . $booking->booking_code);
    }
}
