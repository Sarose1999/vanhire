<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Van;
use App\Models\Booking;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalVans = Van::count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('totalVans', 'totalBookings', 'totalUsers'));
    }
}

