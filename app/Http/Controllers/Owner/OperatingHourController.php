<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OperatingHourController extends Controller
{
    // Menampilkan jadwal operasional venue.
    public function index(Request $request, int $venueId): View
    {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $operatingHours = $venue->operatingHours()
            ->orderBy('weekday')
            ->get();

        return view('owner.venues.operating-hours.index', compact(
            'venue',
            'operatingHours'
        ));
    }

    // Menampilkan formulir edit jadwal operasional.
    public function edit(Request $request, int $venueId): View
    {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $operatingHours = $venue->operatingHours()
            ->get()
            ->keyBy('weekday');

        return view('owner.venues.operating-hours.edit', compact(
            'venue',
            'operatingHours'
        ));
    }

    // Menyimpan perubahan jadwal operasional.
    public function update(Request $request, int $venueId): RedirectResponse
    {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $validated = $request->validate([
            'hours' => ['required', 'array', 'size:7'],
            'hours.*.weekday' => ['required', 'integer', 'between:1,7'],
            'hours.*.is_closed' => ['required', 'boolean'],
            'hours.*.open_time' => ['nullable', 'date_format:H:i'],
            'hours.*.close_time' => ['nullable', 'date_format:H:i'],
        ]);

        $hours = collect($validated['hours']);

        // Memastikan setiap hari hanya dikirim satu kali.
        if ($hours->pluck('weekday')->unique()->count() !== 7) {
            throw ValidationException::withMessages([
                'hours' => 'Jadwal harus berisi tujuh hari yang berbeda.',
            ]);
        }

        foreach ($hours as $hour) {
            if (!$hour['is_closed']) {
                if (
                    empty($hour['open_time']) ||
                    empty($hour['close_time'])
                ) {
                    throw ValidationException::withMessages([
                        'hours' => 'Jam buka dan tutup wajib diisi untuk hari operasional.',
                    ]);
                }

                if ($hour['close_time'] <= $hour['open_time']) {
                    throw ValidationException::withMessages([
                        'hours' => 'Jam tutup harus lebih besar daripada jam buka.',
                    ]);
                }
            }
        }

        DB::transaction(function () use ($venue, $hours) {
            foreach ($hours as $hour) {
                $existing = $venue->operatingHours()
                    ->where('weekday', $hour['weekday'])
                    ->first();

                // Hari libur tetap menyimpan rentang waktu yang valid.
                $openTime = $hour['open_time']
                    ?? $existing?->open_time
                    ?? '08:00';

                $closeTime = $hour['close_time']
                    ?? $existing?->close_time
                    ?? '22:00';

                $venue->operatingHours()->updateOrCreate(
                    ['weekday' => $hour['weekday']],
                    [
                        'open_time' => $openTime,
                        'close_time' => $closeTime,
                        'is_closed' => $hour['is_closed'],
                    ]
                );
            }
        });

        return redirect()
            ->route('owner.venues.operating-hours.index', $venue->id)
            ->with('success', 'Jadwal operasional berhasil diperbarui.');
    }
}