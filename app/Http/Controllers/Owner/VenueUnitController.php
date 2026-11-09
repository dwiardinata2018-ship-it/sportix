<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VenueUnitController extends Controller
{
    /**
     * Menampilkan daftar unit milik suatu venue.
     */
    public function index(Request $request, int $venueId): View
    {
        // Memastikan venue adalah milik Owner yang login.
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        // Mengambil seluruh unit milik venue tersebut.
        $units = $venue->units()
            ->orderBy('id')
            ->get();

        return view('owner.venues.units.index', compact(
            'venue',
            'units'
        ));
        
    }
    
    /**
     * Menampilkan formulir tambah unit venue.
     */
    public function create(Request $request, int $venueId): View
    {
        // Memastikan venue adalah milik Owner yang login.
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        return view('owner.venues.units.create', compact('venue'));
    }

        /**
     * Menyimpan unit baru ke database.
     */
    public function store(Request $request, int $venueId): RedirectResponse
    {
        // Memastikan venue adalah milik Owner yang login.
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        // Memeriksa data yang dikirim dari formulir.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'unit_type' => [
                'required',
                'string',
                'in:court,room,pool,field,other',
            ],
            'description' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'default_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Menyimpan unit melalui relasi venue.
        $venue->units()->create($validated);

        return redirect()
            ->route('owner.venues.units.index', $venue->id)
            ->with('success', 'Unit venue berhasil ditambahkan.');
    }
        /**
     * Menampilkan formulir edit unit venue.
     */
    public function edit(
        Request $request,
        int $venueId,
        int $unitId
    ): View {
        // Memastikan venue adalah milik Owner yang login.
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        // Memastikan unit tersebut benar-benar milik venue.
        $unit = $venue->units()
            ->findOrFail($unitId);

        return view('owner.venues.units.edit', compact(
            'venue',
            'unit'
        ));
    }
        /**
     * Memperbarui data unit venue.
     */
    public function update(
        Request $request,
        int $venueId,
        int $unitId
    ): RedirectResponse {
        // Memastikan venue adalah milik Owner yang login.
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        // Memastikan unit tersebut milik venue.
        $unit = $venue->units()
            ->findOrFail($unitId);

        // Memvalidasi data dari formulir.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'unit_type' => [
                'required',
                'string',
                'in:court,room,pool,field,other',
            ],
            'description' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'default_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Menyimpan perubahan data unit.
        $unit->update($validated);

        return redirect()
            ->route('owner.venues.units.index', $venue->id)
            ->with('success', 'Data unit berhasil diperbarui.');
    }
        /**
     * Mengubah status aktif atau nonaktif unit.
     */
    public function toggleStatus(
        Request $request,
        int $venueId,
        int $unitId
    ): RedirectResponse {
        // Memastikan venue adalah milik Owner yang login.
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        // Memastikan unit tersebut milik venue.
        $unit = $venue->units()
            ->findOrFail($unitId);

        // Mengubah status unit.
        $unit->update([
            'is_active' => !$unit->is_active,
        ]);

        $pesan = $unit->is_active
            ? 'Unit berhasil diaktifkan.'
            : 'Unit berhasil dinonaktifkan.';

        return redirect()
            ->route('owner.venues.units.index', $venue->id)
            ->with('success', $pesan);
    }
}

