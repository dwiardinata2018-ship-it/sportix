<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    // Menampilkan daftar venue favorit milik User.
    public function index(Request $request): View
    {
        $favorites = Favorite::with([
            'venue.sport',
            'venue.images',
        ])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(9);

        return view('user.favorite.index', compact('favorites'));
    }

    // Menambahkan venue ke daftar favorit.
    public function store(Request $request, int $venueId): RedirectResponse
    {
        $venue = Venue::where('verification_status', 'verified')
            ->where('venue_status', 'active')
            ->findOrFail($venueId);

        Favorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'venue_id' => $venue->id,
        ]);

        return back()->with('success', 'Venue berhasil ditambahkan ke favorit.');
    }

    // Menghapus venue dari daftar favorit.
    public function destroy(Request $request, int $venueId): RedirectResponse
    {
        Favorite::where('user_id', $request->user()->id)
            ->where('venue_id', $venueId)
            ->delete();

        return back()->with('success', 'Venue berhasil dihapus dari favorit.');
    }
}
