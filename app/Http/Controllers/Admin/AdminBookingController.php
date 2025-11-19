<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminBookingController extends Controller
{
    // Show all bookings with search + pagination
    public function index(Request $request)
    {
        $query = Booking::with(['user','van'])->orderBy('created_at','desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search){
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('van', function($q) use ($search){
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('start_date', 'like', "%{$search}%");
        }

        $bookings = $query->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    // Show single booking - supports both full page and modal views
    public function show($id)
    {
        $booking = Booking::with(['user','van'])->findOrFail($id);

        // Check if it's an AJAX request or modal request
        if (request()->ajax() || request()->has('modal')) {
            return view('admin.bookings.partials.modal-content', compact('booking'));
        }

        return view('admin.bookings.show', compact('booking'));
    }

    // Delete a booking
    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            // If AJAX/json request, return JSON response for frontend updates
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'removed' => true,
                    'deleted' => true,
                    'message' => 'Booking deleted successfully.',
                ], 200);
            }

            return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting booking: ' . $e->getMessage(),
                ], 400);
            }
            return back()->with('error', 'Error deleting booking.');
        }
    }

    // Export bookings to Excel with total earnings
    public function export(Request $request)
    {
        $search = $request->query('search'); // optional search
        return Excel::download(new BookingsExport($search), 'bookings.xlsx');
    }

    // Update booking status with AJAX support
    public function updateStatus(Request $request, $id)
    {
        // Validate only if 'status' is provided
        if ($request->filled('status')) {
            $request->validate([
                'status' => 'required|in:pending,approved,completed,cancelled',
            ]);
        }

        $booking = Booking::findOrFail($id);

        // Only update status if provided
        if ($request->filled('status')) {
            $booking->status = $request->status;
            $booking->save();
        }

        // If AJAX/json request, return JSON so frontend can update without reload
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $booking->status,
                'message' => 'Booking status updated successfully.',
            ]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking status updated successfully.');
    }

    // Download invoice as PDF
    public function download($id)
    {
        try {
            $booking = Booking::with(['user','van'])->findOrFail($id);

            // Generate PDF invoice
            $pdf = Pdf::loadView('admin.bookings.invoice-pdf', compact('booking'));

            // Set PDF options for better quality
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOption('dpi', 150);
            $pdf->setOption('defaultFont', 'DejaVu Sans');
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('isHtml5ParserEnabled', true);

            // Download the PDF with a professional filename
            return $pdf->download('invoice-booking-' . $booking->id . '-' . date('Y-m-d') . '.pdf');

        } catch (\Exception $e) {
            // Fallback: If PDF generation fails, redirect to HTML invoice
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error generating PDF: ' . $e->getMessage(),
                    'fallback_url' => route('admin.bookings.invoice', $id)
                ], 400);
            }

            return redirect()->route('admin.bookings.invoice', $id)
                            ->with('error', 'PDF generation failed: ' . $e->getMessage());
        }
    }

    // Generate invoice view for printing
    public function invoice($id)
    {
        try {
            $booking = Booking::with(['user','van'])->findOrFail($id);

            // Return invoice view for printing
            return view('admin.bookings.invoice', compact('booking'));

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error loading invoice: ' . e->getMessage(),
                ], 400);
            }
            return back()->with('error', 'Error loading invoice: ' . $e->getMessage());
        }
    }
}
