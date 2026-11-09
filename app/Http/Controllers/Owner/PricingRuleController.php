<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class PricingRuleController extends Controller
{
    // Menampilkan daftar aturan harga milik venue.
    public function index(Request $request, int $venueId): View
    {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $pricingRules = $venue->pricingRules()
            ->with('unit')
            ->orderBy('weekday')
            ->orderBy('start_time')
            ->get();

        return view('owner.venues.pricing-rules.index', compact(
            'venue',
            'pricingRules'
        ));
    }

    // Menampilkan formulir tambah aturan harga.
    public function create(Request $request, int $venueId): View
    {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $units = $venue->units()
            ->orderBy('name')
            ->get();

        return view('owner.venues.pricing-rules.create', compact(
            'venue',
            'units'
        ));
    }

    // Menyimpan aturan harga baru.
    public function store(Request $request, int $venueId): RedirectResponse
    {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $validated = $request->validate([
            'unit_id' => [
                'nullable',
                'integer',
                Rule::exists('venue_units', 'id')
                    ->where('venue_id', $venue->id),
            ],
            'name' => ['required', 'string', 'max:120'],
            'weekday' => ['nullable', 'integer', 'between:1,7'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['nullable', 'date'],
            'effective_until' => [
                'nullable',
                'date',
                'after_or_equal:effective_from',
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        $venue->pricingRules()->create($validated);

        return redirect()
            ->route('owner.venues.pricing-rules.index', $venue->id)
            ->with('success', 'Aturan harga berhasil ditambahkan.');
    }

    // Menampilkan formulir edit aturan harga.
    public function edit(
        Request $request,
        int $venueId,
        int $ruleId
    ): View {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $pricingRule = $venue->pricingRules()
            ->findOrFail($ruleId);

        $units = $venue->units()
            ->orderBy('name')
            ->get();

        return view('owner.venues.pricing-rules.edit', compact(
            'venue',
            'pricingRule',
            'units'
        ));
    }

    // Menyimpan perubahan aturan harga.
    public function update(
        Request $request,
        int $venueId,
        int $ruleId
    ): RedirectResponse {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $pricingRule = $venue->pricingRules()
            ->findOrFail($ruleId);

        $validated = $request->validate([
            'unit_id' => [
                'nullable',
                'integer',
                Rule::exists('venue_units', 'id')
                    ->where('venue_id', $venue->id),
            ],
            'name' => ['required', 'string', 'max:120'],
            'weekday' => ['nullable', 'integer', 'between:1,7'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['nullable', 'date'],
            'effective_until' => [
                'nullable',
                'date',
                'after_or_equal:effective_from',
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        $pricingRule->update($validated);

        return redirect()
            ->route('owner.venues.pricing-rules.index', $venue->id)
            ->with('success', 'Aturan harga berhasil diperbarui.');
    }
    // Menghapus aturan harga milik venue.
    public function destroy(
        Request $request,
        int $venueId,
        int $ruleId
    ): RedirectResponse {
        $venue = $request->user()
            ->venues()
            ->findOrFail($venueId);

        $pricingRule = $venue->pricingRules()
            ->findOrFail($ruleId);

        $pricingRule->delete();

        return redirect()
            ->route('owner.venues.pricing-rules.index', $venue->id)
            ->with('success', 'Aturan harga berhasil dihapus.');
    }
}
