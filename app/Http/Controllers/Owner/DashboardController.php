<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $owner = $request->user();

        // Mengambil seluruh venue milik Owner yang sedang login.
        $venues = $owner->venues()
            ->with('sport')
            ->latest()
            ->get();

        // Menghitung jumlah venue berdasarkan status.
        $totalVenues = $venues->count();

        $activeVenues = $venues->where(
            'venue_status',
            'active'
        )->count();

        $pendingVenues = $venues->where(
            'verification_status',
            'pending'
        )->count();

        $rejectedVenues = $venues->where(
            'verification_status',
            'rejected'
        )->count();

        return view('owner.dashboard', compact(
            'venues',
            'totalVenues',
            'activeVenues',
            'pendingVenues',
            'rejectedVenues'
        ));
    }
}