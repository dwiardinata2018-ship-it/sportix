<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VenueController extends Controller
{
    // Menampilkan daftar seluruh lapangan.
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $verificationStatus = $request->input('verification_status');
        $venueStatus = $request->input('venue_status');

        $venues = Venue::with([
                'owner',
                'sport',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhereHas('owner', function ($ownerQuery) use ($search) {
                            $ownerQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($verificationStatus, function ($query, $verificationStatus) {
                $query->where(
                    'verification_status',
                    $verificationStatus
                );
            })
            ->when($venueStatus, function ($query, $venueStatus) {
                $query->where(
                    'venue_status',
                    $venueStatus
                );
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalVenues = Venue::count();

        $verifiedVenues = Venue::where(
            'verification_status',
            'verified'
        )->count();

        $pendingVenues = Venue::where(
            'verification_status',
            'pending'
        )->count();

        $rejectedVenues = Venue::where(
            'verification_status',
            'rejected'
        )->count();

        $activeVenues = Venue::where(
            'venue_status',
            'active'
        )->count();

        $inactiveVenues = Venue::where(
            'venue_status',
            'inactive'
        )->count();

        return view('admin.venues.index', compact(
            'venues',
            'search',
            'verificationStatus',
            'venueStatus',
            'totalVenues',
            'verifiedVenues',
            'pendingVenues',
            'rejectedVenues',
            'activeVenues',
            'inactiveVenues'
        ));
    }
}