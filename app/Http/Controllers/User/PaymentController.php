<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\PaymentRecord;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function show(
        int $id,
        MidtransService $midtransService
    ): View {
        $booking = Booking::with([
            'venue',
            'unit',
            'paymentRecord',
        ])
            ->where('user_id', Auth::id())
            ->whereKey($id)
            ->firstOrFail();

        if ($booking->booking_status !== 'confirmed') {
            abort(403, 'Booking belum dikonfirmasi oleh Owner.');
        }

        if (!$booking->paymentRecord) {
            abort(404, 'Data pembayaran tidak ditemukan.');
        }

        $payment = $booking->paymentRecord;

        // Perbarui status pembayaran dari Midtrans.
        if ($payment->midtrans_order_id) {
            try {
                $payment = $midtransService->refreshPaymentStatus(
                    $payment
                );
            } catch (\Throwable $e) {
                Log::warning(
                    'Gagal memperbarui status pembayaran Midtrans.',
                    [
                        'payment_id' => $payment->id,
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }

        $booking->setRelation('paymentRecord', $payment);

        return view('user.payment.show', compact('booking'));
    }

        /**
     * Meminta pembuatan ulang QRIS.
     */
    public function retry(
        int $id,
        MidtransService $midtransService
    ): RedirectResponse {
        $booking = Booking::with('paymentRecord')
            ->where('user_id', Auth::id())
            ->whereKey($id)
            ->firstOrFail();

        if ($booking->booking_status !== 'confirmed') {
            abort(403, 'Booking tidak dapat dibayar.');
        }

        $payment = $booking->paymentRecord;

        if (!$payment) {
            abort(404, 'Data pembayaran tidak ditemukan.');
        }

        if ($payment->payment_status === 'paid') {
            return redirect()
                ->route('user.booking.payment', $booking->id)
                ->with('success', 'Pembayaran booking ini sudah lunas.');
        }

        try {
            $midtransService->createQrisTransaction($payment);

            return redirect()
                ->route('user.booking.payment', $booking->id)
                ->with('success', 'QRIS berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Throwable $e) {
            Log::warning('Permintaan retry QRIS Sportix gagal.', [
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('user.booking.payment', $booking->id)
                ->with(
                    'error',
                    'QRIS belum berhasil dibuat. Silakan coba beberapa saat lagi.'
                );
        }
    }

    public function selectCash(int $id): RedirectResponse
    {
        $booking = Booking::with('paymentRecord')
            ->where('user_id', Auth::id())
            ->whereKey($id)
            ->firstOrFail();

        if ($booking->booking_status !== 'confirmed') {
            abort(403, 'Booking belum dapat dibayar.');
        }

        $payment = $booking->paymentRecord;

        if (!$payment) {
            abort(404, 'Data pembayaran tidak ditemukan.');
        }

        if ($payment->payment_status === 'paid') {
            return redirect()
                ->route('user.booking.payment', $booking->id)
                ->with('success', 'Pembayaran booking ini sudah lunas.');
        }

        if ($payment->midtrans_order_id) {
            return redirect()
                ->route('user.booking.payment', $booking->id)
                ->with(
                    'error',
                    'Booking ini sudah memiliki transaksi QRIS. Silakan lanjutkan pembayaran QRIS.'
                );
        }

        $payment->update([
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
        ]);

        return redirect()
            ->route('user.booking.payment', $booking->id)
            ->with(
                'success',
                'Metode pembayaran Cash berhasil dipilih. Silakan bayar langsung kepada Owner sebelum check-in.'
            );
    }
}