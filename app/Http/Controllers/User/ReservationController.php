<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;
use App\Models\BlockedSlot;
use Carbon\Carbon;
use App\Models\PricingRule;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        // Mengambil kategori olahraga yang aktif.
        $sports = Sport::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Mengambil venue yang sudah diverifikasi dan aktif.
        $venues = Venue::with([
                'sport',

                // Mengambil foto venue.
                // Foto utama ditampilkan lebih dahulu.
                'images' => function ($query) {
                    $query->orderByDesc('is_primary')
                        ->orderBy('display_order');
                },

                // Mengambil unit yang masih aktif.
                'units' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->where('verification_status', 'verified')
            ->where('venue_status', 'active')
            ->whereHas('sport', function ($query) {
                $query->where('is_active', true);
            });

        // Fitur pencarian nama venue dan lokasi.
        if ($request->filled('search')) {
            $search = $request->search;

            $venues->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori olahraga.
        if ($request->filled('sport')) {
            $venues->where('sport_id', $request->sport);
        }

        // Mengurutkan dan membatasi data per halaman.
        $venues = $venues->latest()
            ->paginate(9)
            ->withQueryString();

        return view('user.reservation.index', compact(
            'venues',
            'sports'
        ));
    }

            // Menampilkan detail sebuah venue.
        // Menampilkan detail sebuah venue.
        public function show(Request $request, string $slug): View
        {
            $venue = Venue::with([
                'sport',

                'images' => function ($query) {
                    $query->orderByDesc('is_primary')
                        ->orderBy('display_order');
                },

                'units' => function ($query) {
                    $query->where('is_active', true);
                },

                'facilities' => function ($query) {
                    $query->where('is_active', true);
                },

                'operatingHours' => function ($query) {
                    $query->orderBy('weekday');
                },

                'pricingRules' => function ($query) {
                    $query->where('is_active', true);
                },

                // Mengambil ulasan yang boleh ditampilkan.
                'reviews' => function ($query) {
                    $query->where('moderation_status', 'visible')
                        ->with('user')
                        ->latest();
                },
            ])
                ->where('slug', $slug)
                ->where('verification_status', 'verified')
                ->where('venue_status', 'active')
                ->firstOrFail();

            // Memeriksa apakah venue sudah difavoritkan User.
            $isFavorited = $request->user()
                ->favorites()
                ->where('venue_id', $venue->id)
                ->exists();

            // Menghitung rata-rata rating dan jumlah ulasan.
            $averageRating = $venue->reviews->avg('rating') ?? 0;
            $reviewCount = $venue->reviews->count();

            return view('user.reservation.detail', compact(
                'venue',
                'isFavorited',
                'averageRating',
                'reviewCount'
            ));
        }
    public function checkAvailability(Request $request, string $slug)
{
    // 1. Validasi tanggal dan waktu yang dipilih User
    $validated = $request->validate([
        'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        'start_time' => ['required', 'date_format:H:i'],
        'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
    ]);

    // 2. Cari venue yang sudah terverifikasi dan aktif
    $venue = Venue::with([
        'units' => function ($query) {
            $query->where('is_active', true);
        },
    ])
        ->where('slug', $slug)
        ->where('verification_status', 'verified')
        ->where('venue_status', 'active')
        ->firstOrFail();

    // 3. Siapkan tanggal dan waktu pencarian
    $date = $validated['date'];
    $startTime = $validated['start_time'];
    $endTime = $validated['end_time'];

    $weekday = Carbon::parse($date)->dayOfWeekIso;

    $startAt = Carbon::parse("$date $startTime");
    $endAt = Carbon::parse("$date $endTime");

    // 4. Periksa jam operasional venue
    $operatingHour = $venue->operatingHours()
        ->where('weekday', $weekday)
        ->first();

    if (
        !$operatingHour ||
        $operatingHour->is_closed ||
        $startTime < substr($operatingHour->open_time, 0, 5) ||
        $endTime > substr($operatingHour->close_time, 0, 5)
    ) {
        return response()->json([
            'success' => true,
            'message' => 'Venue tutup atau waktu yang dipilih di luar jam operasional.',
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'available_units' => [],
            'unavailable_units' => [],
        ]);
    }

    // 5. Periksa setiap unit olahraga
    $availableUnits = [];
    $unavailableUnits = [];

    foreach ($venue->units as $unit) {

        // Periksa jadwal blokir unit
        $isBlocked = BlockedSlot::where('unit_id', $unit->id)
            ->where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt)
            ->exists();

        if ($isBlocked) {
            $unavailableUnits[] = [
                'unit_id' => $unit->id,
                'unit_name' => $unit->name,
                'reason' => 'Unit sedang diblokir pada waktu tersebut.',
            ];

            continue;
        }

        // Periksa booking yang waktunya bertabrakan
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
            $unavailableUnits[] = [
                'unit_id' => $unit->id,
                'unit_name' => $unit->name,
                'reason' => 'Unit sudah memiliki booking pada waktu tersebut.',
            ];

            continue;
        }

        // Jika tidak ada bentrok, unit tersedia
        // Cari aturan harga yang sesuai dengan unit dan waktu pemesanan
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

        // Jika tidak ada aturan harga yang cocok
        if (!$pricingRule) {
            $unavailableUnits[] = [
                'unit_id' => $unit->id,
                'unit_name' => $unit->name,
                'reason' => 'Aturan harga tidak ditemukan untuk waktu tersebut.',
            ];

            continue;
        }

        // Hitung durasi pemesanan dalam menit
        $durationMinutes = $startAt->diffInMinutes($endAt);

        // Ambil harga per jam dari aturan harga
        $pricePerHour = (float) $pricingRule->price_per_hour;

        // Hitung total harga
        $totalPrice = round(
            ($pricePerHour / 60) * $durationMinutes,
            2
        );

        // Masukkan unit ke daftar tersedia
        $availableUnits[] = [
            'unit_id' => $unit->id,
            'unit_name' => $unit->name,
            'pricing_rule' => $pricingRule->name,
            'duration_minutes' => $durationMinutes,
            'price_per_hour' => $pricePerHour,
            'total_price' => $totalPrice,
            'status' => 'available',
        ];
    }

    // 6. Kirim hasil pemeriksaan
    return response()->json([
        'success' => true,
        'message' => count($availableUnits) > 0
            ? 'Unit tersedia ditemukan.'
            : 'Tidak ada unit yang tersedia pada waktu tersebut.',
        'date' => $date,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'available_units' => $availableUnits,
        'unavailable_units' => $unavailableUnits,
    ]);
}
}
