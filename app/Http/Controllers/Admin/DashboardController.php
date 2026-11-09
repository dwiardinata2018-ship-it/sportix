<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Venue;
use App\Models\Booking;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik akun berdasarkan role.
        $totalUsers = User::where('role', 'user')->count();

        $totalOwners = User::where('role', 'owner')->count();

        $totalAdmins = User::where('role', 'admin')->count();

        // Statistik akun aktif.
        $activeUsers = User::where('role', 'user')
            ->where('account_status', 'active')
            ->count();

        $activeOwners = User::where('role', 'owner')
            ->where('account_status', 'active')
            ->count();

        // Statistik lapangan.
        $totalVenues = Venue::count();

        $pendingVenues = Venue::where('verification_status', 'pending')
            ->count();

        $activeVenues = Venue::where('verification_status', 'verified')
            ->where('venue_status', 'active')
            ->count();

        $inactiveVenues = Venue::where('venue_status', 'inactive')
            ->count();

        // Statistik booking dan ulasan.
        $totalBookings = Booking::count();

        $totalReviews = Review::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOwners',
            'totalAdmins',
            'activeUsers',
            'activeOwners',
            'totalVenues',
            'pendingVenues',
            'activeVenues',
            'inactiveVenues',
            'totalBookings',
            'totalReviews'
        ));
    }
}
