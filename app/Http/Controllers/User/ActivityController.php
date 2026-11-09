<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $userId = $request->user()->id;

        // Ambil riwayat perubahan status booking milik User.
        $statusActivities = BookingStatusHistory::with([
            'booking.venue',
            'booking.unit',
        ])
            ->whereHas('booking', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->map(function ($history) {
                return [
                    'type' => 'booking',
                    'title' => $this->formatBookingStatus(
                        $history->new_status
                    ),
                    'description' => $history->notes
                        ?: 'Status booking diperbarui.',
                    'booking_code' => $history->booking->booking_code,
                    'venue' => $history->booking->venue->name ?? '-',
                    'unit' => $history->booking->unit->name ?? '-',
                    'status' => $history->new_status,
                    'created_at' => $history->created_at,
                ];
            });

        // Ambil aktivitas pembayaran milik User.
        $paymentActivities = PaymentRecord::with([
            'booking.venue',
            'booking.unit',
        ])
            ->whereHas('booking', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->map(function ($payment) {
                return [
                    'type' => 'payment',
                    'title' => $this->formatPaymentStatus($payment->payment_status),
                    'description' => 'Pembayaran booking '.$payment->booking->booking_code.' sebesar Rp'.number_format($payment->amount, 0, ',', '.'),
                    'booking_id' => $payment->booking_id,
                    'booking_code' => $payment->booking->booking_code,
                    'venue' => $payment->booking->venue->name ?? '-',
                    'unit' => $payment->booking->unit->name ?? '-',
                    'status' => $payment->payment_status,
                    'created_at' => $payment->updated_at,
                ];
            });

        // Gabungkan seluruh aktivitas dan urutkan dari terbaru.
        $activities = $statusActivities
            ->concat($paymentActivities)
            ->sortByDesc('created_at')
            ->values();

        // Pagination sederhana untuk koleksi aktivitas.
        $perPage = 10;
        $page = max(1, $request->integer('page', 1));

        $paginatedActivities = new \Illuminate\Pagination\LengthAwarePaginator(
            $activities->forPage($page, $perPage),
            $activities->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('user.activity.index', [
            'activities' => $paginatedActivities,
        ]);
    }

    private function formatBookingStatus(string $status): string
    {
        return match ($status) {
            'pending_confirmation' => 'Booking Dibuat',
            'confirmed' => 'Booking Dikonfirmasi',
            'rejected' => 'Booking Ditolak',
            'cancelled' => 'Booking Dibatalkan',
            'checked_in' => 'Check-in Berhasil',
            'completed' => 'Booking Selesai',
            'expired' => 'Booking Kedaluwarsa',
            default => 'Status Booking Diperbarui',
        };
    }

    private function formatPaymentStatus(string $status): string
    {
        return match ($status) {
            'unpaid' => 'Pembayaran Belum Lunas',
            'awaiting_verification' => 'Pembayaran Menunggu Verifikasi',
            'paid' => 'Pembayaran Berhasil',
            'payment_disputed' => 'Pembayaran Bermasalah',
            'refunded' => 'Pembayaran Dikembalikan',
            default => 'Status Pembayaran Diperbarui',
        };
    }
}
