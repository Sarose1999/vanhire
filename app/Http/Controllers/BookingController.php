<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Van;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
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
                })
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('pickup_location', 'like', "%{$search}%")
                ->orWhere('dropoff_location', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(10);

        // Admin notifications
        $notifications = Auth::user()->unreadNotifications ?? collect();

        return view('bookings.index', compact('bookings', 'notifications'));
    }

    public function create(Van $van)
    {
        return view('bookings.create', compact('van'));
    }

    public function store(Request $request, Van $van)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'time'       => 'required',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
        ]);

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);

        $totalDays = $start->diffInDays($end, false) + 1;
        if ($totalDays < 1) {
            $totalDays = 1;
        }

        $totalPrice = $totalDays * $van->price_per_day;

        $overlapExists = Booking::where('van_id', $van->id)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                  ->orWhereBetween('end_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start->format('Y-m-d'))
                         ->where('end_date', '>=', $end->format('Y-m-d'));
                  });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($overlapExists) {
            return back()->withInput()->with('error', 'Van not available for the selected dates.');
        }

        Booking::create([
            'user_id'     => Auth::id(),
            'van_id'      => $van->id,
            'start_date'  => $start->format('Y-m-d'),
            'end_date'    => $end->format('Y-m-d'),
            'time'        => $request->time,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'total_days'  => $totalDays,
            'total_price' => $totalPrice,
            'status'      => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking successful!');
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function show($id)
    {
        $booking = Booking::with('van')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::with(['van', 'user'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.bookings.invoice', compact('booking'));
        return $pdf->download('Booking-Invoice-' . $booking->id . '.pdf');
    }

    public function invoice(Booking $booking)
    {
        return view('admin.bookings.invoice', compact('booking'));
    }

    public function checkAvailability(Van $van, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');

        $overlapExists = Booking::where('van_id', $van->id)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_date', '<=', $start)
                         ->where('end_date', '>=', $end);
                  });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        return response()->json([
            'available' => !$overlapExists,
            'message' => $overlapExists
                ? 'Van not available for selected dates.'
                : 'Van is available for selected dates.'
        ]);
    }

    public function markAsRead(Booking $booking)
    {
        $booking->update(['is_viewed_by_admin' => true]);
        return response()->json(['success' => true]);
    }
}
