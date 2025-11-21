<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f94144;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .bookings-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .booking-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 4px solid var(--primary);
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .booking-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%);
            padding: 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .booking-body {
            padding: 1.5rem;
        }

        .booking-footer {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .van-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .booking-id {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .info-item {
            display: flex;
            margin-bottom: 0.75rem;
            align-items: flex-start;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.1rem;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark);
        }

        .price-tag {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1.25rem;
            display: inline-block;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-pending {
            background: rgba(248, 150, 30, 0.15);
            color: var(--warning);
        }

        .badge-approved {
            background: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }

        .badge-completed {
            background: rgba(67, 97, 238, 0.15);
            color: var(--primary);
        }

        .badge-cancelled {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }

        .btn-action {
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-view {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-view:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
        }

        .btn-cancel {
            background: rgba(249, 65, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(249, 65, 68, 0.2);
        }

        .btn-cancel:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(249, 65, 68, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .filter-tabs {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .nav-pills .nav-link {
            border-radius: 30px;
            padding: 0.5rem 1.5rem;
            margin-right: 0.5rem;
            font-weight: 600;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.3s;
        }

        .nav-pills .nav-link:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .booking-count {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .no-bookings-message {
            text-align: center;
            padding: 3rem 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            display: none;
        }

        /* Notification Section */
        .notifications-container {
            margin-bottom: 1.5rem;
        }

        .notification-card {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-message {
            font-weight: 600;
            color: #856404;
        }

        .notification-form button {
            background: none;
            border: none;
            color: #0d6efd;
            font-weight: 600;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .booking-card {
                margin-bottom: 1rem;
            }

            .info-item {
                flex-direction: column;
            }

            .info-icon {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4 bookings-container">

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                    <h1 class="h3 mb-1">My Bookings</h1>
                    <p class="text-muted mb-0">Manage and track your van rentals</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-dark fs-6" id="total-bookings-count">{{ $bookings->count() }} booking(s)</span>
                </div>
            </div>
        </div>

        <!-- Admin Notifications -->
        @php
            $notifications = auth()->user()->unreadNotifications;
        @endphp

        @if($notifications->count() > 0)
        <div class="notifications-container">
            @foreach($notifications as $note)
            <div class="notification-card">
                <div class="notification-message">
                    {{ $note->data['message'] }} (Booking #{{ $note->data['booking_id'] }})
                </div>
             <form method="POST" action="{{ route('admin.notifications.read', $note->id) }}">
                    @csrf
                    <button type="submit">Mark as Read</button>
                </form>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <ul class="nav nav-pills" id="bookingFilterTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-status="all">All Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="pending">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="approved">Approved</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="completed">Completed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-status="cancelled">Cancelled</a>
                </li>
            </ul>
            <div class="booking-count" id="filtered-count">
                Showing all {{ $bookings->count() }} bookings
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="bookings-list" id="bookingsList">
                @foreach($bookings as $booking)
                <div class="booking-card" data-status="{{ $booking->status }}">
                    <!-- Booking Header -->
                    <div class="booking-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="van-name">{{ $booking->van->name }}</div>
                                <div class="booking-id">Booking #{{ $booking->id }}</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="status-badge {{ 'badge-' . $booking->status }} me-3">
                                    @if($booking->status == 'pending')
                                        <i class="bi bi-hourglass-split me-1"></i> Pending
                                    @elseif($booking->status == 'approved')
                                        <i class="bi bi-check-circle me-1"></i> Approved
                                    @elseif($booking->status == 'completed')
                                        <i class="bi bi-flag me-1"></i> Completed
                                    @elseif($booking->status == 'cancelled')
                                        <i class="bi bi-x-circle me-1"></i> Cancelled
                                    @else
                                        Unknown
                                    @endif
                                </div>
                                <div class="price-tag">Rs. {{ number_format($booking->total_price, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Body -->
                    <div class="booking-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Pick-up Location</div>
                                        <div class="info-value">{{ $booking->pickup_location ?? 'N/A' }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Drop-off Location</div>
                                        <div class="info-value">{{ $booking->dropoff_location ?? 'N/A' }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Rental Period</div>
                                        <div class="info-value">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="far fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Pick-up Time</div>
                                        <div class="info-value">{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Total Days</div>
                                        <div class="info-value">{{ $booking->total_days }} day(s)</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="far fa-calendar-check"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Booking Date</div>
                                        <div class="info-value">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Footer -->
                    <div class="booking-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($booking->status == 'pending')
                                    <span class="text-warning">
                                        <i class="fas fa-info-circle me-1"></i> Waiting for approval
                                    </span>
                                @elseif($booking->status == 'approved')
                                    <span class="text-success">
                                        <i class="fas fa-check me-1"></i> Ready for pickup
                                    </span>
                                @elseif($booking->status == 'completed')
                                    <span class="text-primary">
                                        <i class="fas fa-flag me-1"></i> Trip completed
                                    </span>
                                @elseif($booking->status == 'cancelled')
                                    <span class="text-muted">
                                        <i class="fas fa-ban me-1"></i> Booking cancelled
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-action btn-view me-2">
                                    <i class="bi bi-eye me-1"></i> View Details
                                </a>

                                @if($booking->status == 'pending')
                                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure to cancel this booking?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action btn-cancel">
                                            <i class="bi bi-x-circle me-1"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- No bookings message for filtered state -->
            <div class="no-bookings-message" id="noBookingsMessage">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="h4 mb-3">No Bookings Found</h3>
                <p class="text-muted mb-4">There are no bookings with the selected status.</p>
                <button class="btn btn-primary" id="resetFilter">
                    <i class="fas fa-redo me-2"></i> Show All Bookings
                </button>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3 class="h4 mb-3">No Bookings Yet</h3>
                <p class="text-muted mb-4">You haven't made any van bookings yet. Start exploring our available vans!</p>
                <a href="{{ route('vans.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-van-shuttle me-2"></i> Browse Vans
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('#bookingFilterTabs .nav-link');
            const bookingCards = document.querySelectorAll('.booking-card');
            const bookingsList = document.getElementById('bookingsList');
            const noBookingsMessage = document.getElementById('noBookingsMessage');
            const filteredCount = document.getElementById('filtered-count');
            const resetFilterBtn = document.getElementById('resetFilter');
            const totalBookingsCount = document.getElementById('total-bookings-count');

            // Store the original total count
            const totalBookings = bookingCards.length;

            // Function to filter bookings by status
            function filterBookings(status) {
                let visibleCount = 0;

                bookingCards.forEach(card => {
                    if (status === 'all' || card.getAttribute('data-status') === status) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update the count display
                if (status === 'all') {
                    filteredCount.textContent = `Showing all ${totalBookings} bookings`;
                } else {
                    filteredCount.textContent = `Showing ${visibleCount} ${status} booking(s)`;
                }

                // Show/hide the no bookings message
                if (visibleCount === 0 && totalBookings > 0) {
                    bookingsList.style.display = 'none';
                    noBookingsMessage.style.display = 'block';
                } else {
                    bookingsList.style.display = 'block';
                    noBookingsMessage.style.display = 'none';
                }
            }

            // Add click event listeners to filter tabs
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    filterTabs.forEach(t => t.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Filter bookings
                    const status = this.getAttribute('data-status');
                    filterBookings(status);
                });
            });

            // Reset filter button
            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', function() {
                    filterTabs.forEach(t => t.classList.remove('active'));
                    filterTabs[0].classList.add('active');
                    filterBookings('all');
                });
            }

            // Initialize with all bookings showing
            filterBookings('all');
        });
    </script>
</body>
</html>
