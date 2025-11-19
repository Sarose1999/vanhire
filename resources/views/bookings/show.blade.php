@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 animate-fade-in">
        <div class="card-header bg-gradient-primary text-white text-center py-4 rounded-top-4">
            <h3 class="mb-0 fw-bold">Booking Details</h3>
            <p class="mb-0 opacity-75">Booking #{{ $booking->id }}</p>
        </div>

        <div class="card-body p-5">
            <div class="row">
                <!-- Van Image -->
                <div class="col-lg-5 text-center mb-4 animate-slide-left">
                    <div class="position-relative">
                        @if($booking->van->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($booking->van->image))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($booking->van->image) }}"
                                 alt="{{ $booking->van->name }}"
                                 class="img-fluid rounded-3 shadow-lg van-image">
                        @else
                            <img src="{{ asset('images/default-van.png') }}"
                                 alt="Default Image"
                                 class="img-fluid rounded-3 shadow-lg van-image">
                        @endif
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success bg-opacity-90 text-white px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Confirmed
                            </span>
                        </div>
                    </div>

                    <!-- Van Quick Info -->
                    <div class="mt-4 p-3 bg-light rounded-3">
                        <h5 class="fw-bold text-primary mb-2">{{ $booking->van->name }}</h5>
                        <div class="d-flex justify-content-between text-sm">
                            <span class="text-muted">
                                <i class="bi bi-people me-1"></i>
                                {{ $booking->van->seats }} Seats
                            </span>
                            <span class="text-muted">
                                <i class="bi bi-speedometer2 me-1"></i>
                                {{ $booking->van->model ?? 'Standard' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Booking Info -->
                <div class="col-lg-7 animate-slide-right">
                    <!-- Location Information -->
                    <div class="info-card mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-primary">
                                <i class="bi bi-geo-alt-fill text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Location Details</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-geo-fill text-primary"></i>
                                    <div>
                                        <small class="text-muted">Pick-up Location</small>
                                        <p class="mb-0 fw-semibold">{{ $booking->pickup_location ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-geo text-success"></i>
                                    <div>
                                        <small class="text-muted">Drop-off Location</small>
                                        <p class="mb-0 fw-semibold">{{ $booking->dropoff_location ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Time Information -->
                    <div class="info-card mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-warning">
                                <i class="bi bi-calendar-check-fill text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Date & Time</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-calendar-plus text-primary"></i>
                                    <div>
                                        <small class="text-muted">Start Date</small>
                                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-calendar-minus text-primary"></i>
                                    <div>
                                        <small class="text-muted">Return Date</small>
                                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-clock text-info"></i>
                                    <div>
                                        <small class="text-muted">Time</small>
                                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-calendar-event text-secondary"></i>
                                    <div>
                                        <small class="text-muted">Booking Time</small>
                                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="info-card mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-success">
                                <i class="bi bi-currency-dollar text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Pricing Details</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-calendar-range text-success"></i>
                                    <div>
                                        <small class="text-muted">Total Days</small>
                                        <p class="mb-0 fw-semibold">{{ $booking->total_days }} days</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <i class="bi bi-tag text-success"></i>
                                    <div>
                                        <small class="text-muted">Price per Day</small>
                                        <p class="mb-0 fw-semibold">Rs. {{ number_format($booking->van->price_per_day, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Price Highlight -->
                        <div class="total-price-section mt-3 p-3 bg-gradient-success text-white rounded-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="opacity-75">TOTAL AMOUNT</small>
                                    <h3 class="mb-0 fw-bold animate-pulse">Rs. {{ number_format($booking->total_price, 2) }}</h3>
                                </div>
                                <div class="price-icon">
                                    <i class="bi bi-wallet2 display-6 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Information -->
                    <div class="info-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper bg-info">
                                <i class="bi bi-info-circle-fill text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Booking Status</h5>
                        </div>
                        <div class="status-badge-container">
                            @if($booking->status == 'confirmed')
                                <span class="status-badge status-confirmed">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Confirmed
                                </span>
                            @elseif($booking->status == 'pending')
                                <span class="status-badge status-pending">
                                    <i class="bi bi-clock-fill me-2"></i>
                                    Pending Approval
                                </span>
                            @elseif($booking->status == 'canceled')
                                <span class="status-badge status-canceled">
                                    <i class="bi bi-x-circle-fill me-2"></i>
                                    Canceled
                                </span>
                            @elseif($booking->status == 'approved')
                                <span class="status-badge status-approved">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Approved
                                </span>
                            @elseif($booking->status == 'completed')
                                <span class="status-badge status-completed">
                                    <i class="bi bi-flag-fill me-2"></i>
                                    Completed
                                </span>
                            @else
                                <span class="status-badge status-unknown">
                                    <i class="bi bi-question-circle-fill me-2"></i>
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-5 animate-fade-up">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-lg action-btn">
                            <i class="bi bi-arrow-left-circle me-2"></i> Back to Bookings
                        </a>

                        @if($booking->status == 'pending')
                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-lg action-btn">
                                <i class="bi bi-x-circle me-2"></i> Cancel Booking
                            </button>
                        </form>
                        @endif

                        <!-- Download Invoice Button -->
                        <a href="{{ route('bookings.invoice', $booking->id) }}" class="btn btn-success btn-lg action-btn">
                            <i class="bi bi-file-earmark-pdf me-2"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer text-center bg-light py-4 rounded-bottom-4">
            <div class="d-flex align-items-center justify-content-center">
                <i class="bi bi-truck text-primary me-2 fs-5"></i>
                <small class="text-muted fw-semibold">Thank you for choosing FS Travels 🚐</small>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    .animate-slide-left { animation: slideInLeft 0.8s ease-out; }
    .animate-slide-right { animation: slideInRight 0.8s ease-out; }
    .animate-fade-up { animation: fadeIn 1s ease-out 0.3s both; }
    .animate-pulse { animation: pulse 2s infinite; }

    /* Custom Styles */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
    }

    .van-image {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 3px solid #fff;
    }

    .van-image:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #e9ecef;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item i {
        font-size: 1.2rem;
        margin-right: 12px;
        width: 24px;
        text-align: center;
    }

    .total-price-section {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    }

    .total-price-section:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);
    }

    .price-icon {
        transition: transform 0.3s ease;
    }

    .total-price-section:hover .price-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .status-confirmed { background: #d1e7dd; color: #0f5132; }
    .status-pending { background: #fff3cd; color: #664d03; }
    .status-canceled { background: #f8d7da; color: #842029; }
    .status-approved { background: #cfe2ff; color: #084298; }
    .status-completed { background: #d1ecf1; color: #0c5460; }
    .status-unknown { background: #e2e3e5; color: #41464b; }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .action-btn {
        transition: all 0.3s ease;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection
