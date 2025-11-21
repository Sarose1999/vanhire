<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Van;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Show all bookings for the logged-in user
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('van')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show booking form for a specific van
     */
    public function create(Van $van)
    {
        return view('bookings.create', compact('van'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request, Van $van)
    {
        // ✅ Validate form input
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'time'       => 'required',
            'pickup_location' => 'required|string|max:255',
        'dropoff_location' => 'required|string|max:255',
        ]);

    // ✅ Calculate total days (inclusive)
        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);

        // diffInDays with second param "false" → returns signed value
        $totalDays = $start->diffInDays($end, false) + 1;

        // ✅ Prevent negative or zero-day values
        if ($totalDays < 1) {
            $totalDays = 1;
        }

        // ✅ Calculate total price
        $totalPrice = $totalDays * $van->price_per_day;

        // Check availability: disallow overlapping bookings for the same van
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
            return back()->withInput()->with('error', 'Van not available for the selected dates. Please choose different dates.');
        }

        // ✅ Create booking record
        Booking::create([
            'user_id'     => Auth::id(),
            'van_id'      => $van->id,
            'start_date'  => $start->format('Y-m-d'),
            'end_date'    => $end->format('Y-m-d'),
            'time'        => $request->time,
            'pickup_location' => $request->pickup_location,
        'dropoff_location' => $request->dropoff_location,
            'total_days'  => $totalDays,        // ✅ Now correctly stored
            'total_price' => $totalPrice,
            'status'      => 'pending',         // Default status
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking successful!');
    }

    /**
     * Cancel a booking (only if pending)
     */
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

    /**
     * Show a single booking (details page)
     */
    public function show($id)
    {
        $booking = Booking::with('van')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Download booking invoice as PDF
     */
    public function downloadInvoice($id)
    {
        $booking = Booking::with(['van', 'user'])->findOrFail($id);

        // Use the admin invoice view for consistent styling when admins download
        // If you prefer the public/user invoice layout, change the view name accordingly
        $pdf = Pdf::loadView('admin.bookings.invoice', compact('booking'));
        return $pdf->download('Booking-Invoice-' . $booking->id . '.pdf');
    }
    public function invoice(Booking $booking)
{
    // For PDF generation, you can use packages like barryvdh/laravel-dompdf
    // For now, let's create a simple HTML invoice that can be printed

    return view('admin.bookings.invoice', compact('booking'));
}

    /**
     * AJAX: check availability for a van between start and end dates
     */
    public function checkAvailability(Van $van, Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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

        if ($overlapExists) {
            return response()->json([
                'available' => false,
                'message' => 'Van not available for selected dates.'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Van is available for the selected dates.'
        ]);
    }

    public function markAsRead(Booking $booking)
{
    $booking->update(['is_viewed_by_admin' => true]);

    return response()->json(['success' => true]);
}



}
