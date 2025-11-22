<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VanController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminVanController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBannerController;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ---------------------------
// Public Routes
// ---------------------------
Route::get('/', [VanController::class, 'index'])->name('home');

// ---------------------------
// Dashboard (authenticated users)
// ---------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [VanController::class, 'index'])->middleware('auth')->name('home');

// ---------------------------
// Authenticated User Routes
// ---------------------------
Route::middleware(['auth'])->group(function () {

    // Redirect /home to main homepage
    Route::get('/home', function () {
        return redirect()->route('home');
    })->name('home');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{van}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store/{van}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/check-availability/{van}', [BookingController::class, 'checkAvailability'])->name('bookings.checkAvailability');
    Route::delete('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{id}/invoice', [BookingController::class, 'downloadInvoice'])->name('bookings.invoice');
});
// Admin routes
Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function() {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // In routes/web.php or routes/admin.php
Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');

  // Mark ALL notifications as read
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])
         ->name('notifications.markAllRead');

    // Mark ONE notification as read
    Route::post('/notifications/read/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])
         ->name('notifications.read');

    // Vans Management

    Route::resource('vans', AdminVanController::class);

    // Bookings Management - Full resource with additional routes
    Route::resource('/bookings', AdminBookingController::class)->except(['create', 'edit', 'update', 'store']);
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])
    ->name('admin.bookings.updateStatus');


    // Additional Booking Routes for Admin
    Route::get('/bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Admin Invoice & Download Routes
    Route::get('/bookings/{id}/invoice', [AdminBookingController::class, 'invoice'])->name('bookings.invoice');
    Route::get('/bookings/{id}/download', [AdminBookingController::class, 'download'])->name('bookings.download');

    // Notification mark as read route
    Route::post('/notifications/read/{id}', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    })->name('notifications.read');

    // Optional: Booking-specific notification mark as read
    Route::post('/bookings/{booking}/mark-read', [BookingController::class, 'markAsRead'])
        ->name('bookings.mark-read');

    // Banner Management
    Route::resource('banners', AdminBannerController::class);
    Route::post('/banners/{banner}/toggle', [AdminBannerController::class, 'toggle'])->name('banners.toggle');

});

require __DIR__.'/auth.php';
