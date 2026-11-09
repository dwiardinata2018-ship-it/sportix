<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan dari User.
     */
    public function store(Request $request, int $bookingId): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $bookingId, $validated) {

            // Mengunci booking dan memastikan booking milik User yang login.
            $booking = Booking::where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->findOrFail($bookingId);

            // Ulasan hanya boleh diberikan setelah booking selesai.
            if ($booking->booking_status !== 'completed') {
                throw ValidationException::withMessages([
                    'rating' => 'Ulasan hanya dapat diberikan setelah booking selesai.',
                ]);
            }

            // Pastikan satu booking belum memiliki ulasan.
            if (Review::where('booking_id', $booking->id)->exists()) {
                throw ValidationException::withMessages([
                    'rating' => 'Booking ini sudah memiliki ulasan.',
                ]);
            }

            Review::create([
                'booking_id' => $booking->id,
                'user_id' => $request->user()->id,
                'venue_id' => $booking->venue_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'moderation_status' => 'visible',
            ]);
        });

        return back()->with('success', 'Terima kasih! Ulasan berhasil dikirim.');
    }
}
