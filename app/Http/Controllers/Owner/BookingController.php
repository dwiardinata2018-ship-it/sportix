<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\PaymentRecord;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    // Menampilkan booking milik Owner yang sedang login.
    public function index(): View
    {
        $bookings = Booking::with([
                'user',
                'venue',
                'unit',
                'paymentRecord',
            ])
            ->whereHas('venue', function ($query) {
                $query->where('owner_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('owner.bookings.index', compact('bookings'));
    }

    // Menampilkan halaman QR Scanner.
    public function checkin(): View
    {
        return view('owner.bookings.checkin');
    }

    // Memvalidasi QR dan memproses check-in.
    

public function storeCheckin(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'token' => ['required', 'string', 'max:255'],
    ]);

    // Ambil input dan bersihkan spasi.
    $input = trim($validated['token']);

    $result = DB::transaction(function () use ($input) {

        // 1. Coba cari booking menggunakan token QR.
        $tokenHash = hash('sha256', $input);

        $booking = Booking::where('checkin_token_hash', $tokenHash)
            ->whereHas('venue', function ($query) {
                $query->where('owner_id', auth()->id());
            })
            ->lockForUpdate()
            ->first();

        // 2. Jika token QR tidak ditemukan, coba gunakan kode booking.
        if (!$booking) {

            $booking = Booking::where('booking_code', strtoupper($input))
                ->whereHas('venue', function ($query) {
                    $query->where('owner_id', auth()->id());
                })
                ->lockForUpdate()
                ->first();

            if (!$booking) {
                return [
                    'success' => false,
                    'message' => 'Kode booking atau QR Code tidak valid, atau bukan milik venue kamu.',
                ];
            }

            // Buat ulang token menggunakan rumus yang sama dengan User.
            $checkinToken = hash_hmac(
                'sha256',
                $booking->booking_code,
                config('app.key')
            );

            $tokenHash = hash('sha256', $checkinToken);

            // Pastikan token cocok dengan hash yang tersimpan.
            if (
                empty($booking->checkin_token_hash) ||
                !hash_equals($booking->checkin_token_hash, $tokenHash)
            ) {
                return [
                    'success' => false,
                    'message' => 'Token booking tidak valid.',
                ];
            }
        }

        // 3. Pastikan booking sudah dikonfirmasi.
        if ($booking->booking_status !== 'confirmed') {
            return [
                'success' => false,
                'message' => 'Booking tidak dapat check-in. Status saat ini: '
                    . $booking->booking_status,
            ];
        }

        // Periksa jadwal booking.
        $bookingStart = \Illuminate\Support\Carbon::parse(
            $booking->booking_date->format('Y-m-d') . ' ' . $booking->start_time
        );

        $bookingEnd = \Illuminate\Support\Carbon::parse(
            $booking->booking_date->format('Y-m-d') . ' ' . $booking->end_time
        );

        $currentTime = now();

        // Tolak check-in sebelum jadwal dimulai.
        if ($currentTime->lt($bookingStart)) {
            return [
                'success' => false,
                'message' => 'Check-in belum dapat dilakukan. Jadwal booking dimulai pukul '
                    . $bookingStart->format('H:i') . '.',
            ];
        }

        // Tolak check-in setelah jadwal selesai.
        if ($currentTime->gt($bookingEnd)) {
            return [
                'success' => false,
                'message' => 'Waktu booking sudah berakhir. Check-in tidak dapat dilakukan.',
            ];
        }

        // 4. Periksa pembayaran.
        $payment = $booking->paymentRecord()
            ->lockForUpdate()
            ->first();

        if (!$payment || $payment->payment_status !== 'paid') {
            return [
                'success' => false,
                'message' => 'Check-in ditolak. Pembayaran booking belum berhasil.',
            ];
        }

        $oldStatus = $booking->booking_status;

        // 5. Perbarui status check-in.
        $booking->update([
            'booking_status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => auth()->id(),
        ]);

        // 6. Simpan riwayat perubahan status.
        BookingStatusHistory::create([
            'booking_id' => $booking->id,
            'changed_by' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => 'checked_in',
            'notes' => 'Check-in berhasil melalui QR Scanner atau kode booking manual oleh Owner.',
        ]);

        // 7. Beri notifikasi kepada User.
        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Check-in Berhasil',
            'message' => 'Booking ' . $booking->booking_code
                . ' telah berhasil melakukan check-in.',
            'notification_type' => 'booking_checked_in',
            'related_type' => 'booking',
            'related_id' => $booking->id,
        ]);

        return [
            'success' => true,
            'message' => 'Check-in berhasil untuk booking '
                . $booking->booking_code . '.',
        ];
    });

    if (!$result['success']) {
        return redirect()
            ->route('owner.bookings.checkin')
            ->with('error', $result['message']);
    }

    return redirect()
        ->route('owner.bookings.index')
        ->with('success', $result['message']);
}
    
/**
 * Menerima booking dan membuat transaksi QRIS.
 */


public function confirm(int $id): RedirectResponse
{
    DB::transaction(function () use ($id) {

        $booking = Booking::whereHas('venue', function ($query) {
                $query->where('owner_id', auth()->id());
            })
            ->whereKey($id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($booking->booking_status !== 'pending_confirmation') {
            abort(403, 'Booking ini tidak dapat dikonfirmasi.');
        }

        $oldStatus = $booking->booking_status;

        $booking->update([
            'booking_status' => 'confirmed',
        ]);

        BookingStatusHistory::create([
            'booking_id' => $booking->id,
            'changed_by' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => 'confirmed',
            'notes' => 'Booking diterima oleh Owner.',
        ]);

        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Booking Dikonfirmasi',
            'message' => 'Booking ' . $booking->booking_code
                . ' telah dikonfirmasi. Silakan pilih metode pembayaran.',
            'notification_type' => 'booking_confirmed',
            'related_type' => 'booking',
            'related_id' => $booking->id,
        ]);

        // Buat satu catatan pembayaran untuk booking ini.
        PaymentRecord::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_method' => 'qris',
                'payment_status' => 'unpaid',
                'amount' => $booking->total_price,
            ]
        );
    });

    return redirect()
        ->route('owner.bookings.index')
        ->with(
            'success',
            'Booking berhasil dikonfirmasi. User dapat memilih metode pembayaran.'
        );
}

    // Menolak permintaan booking.
    public function reject(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $booking = Booking::whereHas('venue', function ($query) {
                    $query->where('owner_id', auth()->id());
                })
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->booking_status !== 'pending_confirmation') {
                abort(403, 'Booking ini tidak dapat ditolak.');
            }

            $oldStatus = $booking->booking_status;

            $booking->update([
                'booking_status' => 'rejected',
            ]);

            BookingStatusHistory::create([
                'booking_id' => $booking->id,
                'changed_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => 'rejected',
                'notes' => 'Booking ditolak oleh Owner.',
            ]);

            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking Ditolak',
                'message' => 'Booking ' . $booking->booking_code
                    . ' telah ditolak oleh Owner.',
                'notification_type' => 'booking_rejected',
                'related_type' => 'booking',
                'related_id' => $booking->id,
            ]);
        });

        return redirect()
            ->route('owner.bookings.index')
            ->with('success', 'Booking berhasil ditolak.');
    }

        /**
     * Menyelesaikan booking setelah User selesai menggunakan venue.
     */
    public function complete(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $booking = Booking::whereHas('venue', function ($query) {
                    $query->where('owner_id', auth()->id());
                })
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            // Booking hanya dapat diselesaikan setelah check-in.
            if ($booking->booking_status !== 'checked_in') {
                abort(403, 'Booking hanya dapat diselesaikan setelah check-in.');
            }

            $oldStatus = $booking->booking_status;

            $booking->update([
                'booking_status' => 'completed',
            ]);

            // Simpan riwayat perubahan status.
            BookingStatusHistory::create([
                'booking_id' => $booking->id,
                'changed_by' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => 'completed',
                'notes' => 'Booking telah diselesaikan oleh Owner.',
            ]);

            // Beri notifikasi kepada User.
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking Selesai',
                'message' => 'Booking ' . $booking->booking_code
                    . ' telah selesai. Silakan berikan ulasan untuk venue.',
                'notification_type' => 'booking_completed',
                'related_type' => 'booking',
                'related_id' => $booking->id,
            ]);
        });

        return redirect()
            ->route('owner.bookings.index')
            ->with('success', 'Booking berhasil diselesaikan.');
    }

    public function confirmCashPayment(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {

            $booking = Booking::whereHas('venue', function ($query) {
                    $query->where('owner_id', auth()->id());
                })
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->booking_status !== 'confirmed') {
                abort(403, 'Booking ini belum dikonfirmasi.');
            }

            $payment = PaymentRecord::where('booking_id', $booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->payment_method !== 'cash') {
                abort(403, 'Pembayaran booking ini bukan Cash.');
            }

            if ($payment->payment_status === 'paid') {
                return;
            }

            if ($payment->payment_status !== 'unpaid') {
                abort(403, 'Status pembayaran tidak dapat dikonfirmasi.');
            }

            $payment->update([
                'payment_status' => 'paid',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'notes' => 'Pembayaran Cash diterima langsung oleh Owner.',
            ]);

            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pembayaran Cash untuk booking '
                    . $booking->booking_code
                    . ' telah dikonfirmasi oleh Owner.',
                'notification_type' => 'payment_paid',
                'related_type' => 'booking',
                'related_id' => $booking->id,
            ]);
        });

        return redirect()
            ->route('owner.bookings.index')
            ->with('success', 'Pembayaran Cash berhasil dikonfirmasi.');
    }
}
