<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Van;
use App\Models\Booking;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;

class VanController extends Controller
{
    public function index(Request $request)
    {
        $query = Van::query();

        // Optional filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('seats')) {
            $query->where('seats', '>=', $request->seats);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        $vans = $query->get();

        $bookings = collect();
        $latestBookingId = null;

        if (Auth::check()) {
            $bookings = Booking::with('van')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            $latestBookingId = $bookings->first()->van_id ?? null;
        }

        // ✅ Only fetch banners that are active (added by admin)
        $banners = Banner::where('is_active', 1)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('home', compact('vans', 'bookings', 'latestBookingId', 'banners'));
    }
}
