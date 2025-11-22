<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Van;
use App\Models\Booking;
use App\Models\User;


class AdminController extends Controller
{
   public function index(Request $request)
{
    $query = Booking::with(['van', 'user']);

    // Search functionality
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('van', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('pickup_location', 'like', "%{$search}%")
              ->orWhere('dropoff_location', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $bookings = $query->latest()->paginate(10);

    // Empty notifications collection for now
    $notifications = collect();

    return view('admin.bookings.index', compact('bookings', 'notifications'));
}
}

