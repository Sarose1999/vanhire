<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Van;
use App\Models\Booking;
use App\Models\Banner; // <- Add this

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Count total users, vans, bookings, and banners
        $totalUsers    = User::count();
        $totalVans     = Van::count();
        $totalBookings = Booking::count();
        $totalBanners  = Banner::count(); // <- Add this

        // Latest 5 bookings
        $recentBookings = Booking::with(['user','van'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Total earnings
        $totalEarnings = Booking::sum('total_price');

        // Latest 5 banners (optional, for display in dashboard)
        $recentBanners = Banner::latest()->take(5)->get(); // <- optional

        // Pass all variables to the dashboard view
        return view('admin.dashboard', compact(
            'totalVans',
            'totalBookings',
            'totalUsers',
            'recentBookings',
            'totalEarnings',
            'totalBanners',   // <- include for stats
            'recentBanners'   // <- include if showing recent banners
        ));
    }
}
