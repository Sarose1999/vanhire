<x-admin-layout>
    <div class="container mx-auto mt-6">
        <h1 class="text-3xl font-bold mb-6">Manage Bookings</h1>

        <!-- Notification Bell & Counter -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-4 items-center">
                <!-- Search + Export -->
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bookings..." class="border px-3 py-2 rounded w-full md:w-64">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Search</button>
                </form>

                <a href="{{ route('admin.bookings.export', ['search' => request('search')]) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition whitespace-nowrap">
                    Export Excel
                </a>
            </div>

            <!-- Notification Bell -->
            <div class="relative">
                <button id="notification-bell" class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-6.24M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @php
                        // Safe way to get notifications count
                        $notificationCount = isset($notifications) ? $notifications->count() : 0;
                    @endphp
                    @if($notificationCount > 0)
                    <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                        {{ $notificationCount }}
                    </span>
                    @endif
                </button>

                <!-- Notification Dropdown -->
                <div id="notification-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50 hidden transform origin-top-right transition-all duration-300 scale-95 opacity-0">
                    <div class="p-3 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">Notifications</h3>
                        <div class="flex gap-2">
                            @if($notificationCount > 0)
                            <form method="POST" action="{{ route('admin.notifications.markAllRead') }}">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">Mark all read</button>
                            </form>
                            <span class="text-gray-400">|</span>
                            @endif
                            <button id="close-notifications" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="notification-list" class="max-h-96 overflow-y-auto">
                        @if($notificationCount > 0)
                            @foreach($notifications as $note)
                            <div class="notification-item border-b border-gray-100 last:border-b-0" data-notification-id="{{ $note->id }}">
                                <div class="p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="h-2 w-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                <span class="text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-800">{{ $note->data['message'] }}</p>
                                            <div class="mt-2 flex justify-between items-center">
                                                <span class="text-xs font-medium text-blue-600">Booking #{{ $note->data['booking_id'] }}</span>
                                                <form method="POST" action="{{ route('admin.notifications.read', $note->id) }}" class="mark-read-form">
                                                    @csrf
                                                    <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-medium">Mark as Read</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="p-4 text-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-6.24M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>No new notifications</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Bookings Table -->
        @if($bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">Van Image</th>
                        <th class="py-2 px-4 text-left">Van</th>
                        <th class="py-2 px-4 text-left">User</th>
                        <th class="py-2 px-4 text-left">Pick-up Location</th>
                        <th class="py-2 px-4 text-left">Drop-off Location</th>
                        <th class="py-2 px-4 text-left">Start</th>
                        <th class="py-2 px-4 text-left">Return</th>
                        <th class="py-2 px-4 text-left">Days</th>
                        <th class="py-2 px-4 text-left">Price ($)</th>
                        <th class="py-2 px-4 text-left">Time</th>
                        <th class="py-2 px-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr class="border-b hover:bg-gray-100" data-booking-id="{{ $booking->id }}">
                        <!-- Van Image -->
                        <td class="py-2 px-4">
                            @php
                                // Normalize image(s) and verify existence on the public disk
                                $images = $booking->van->images ?? null;
                                if (is_string($images)) {
                                    $decoded = json_decode($images, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        $images = $decoded;
                                    } else {
                                        $images = array_filter(array_map('trim', explode(',', $images)));
                                    }
                                }

                                $firstImage = null;

                                // Try singular image field first
                                if (!empty($booking->van->image)) {
                                    $candidate = ltrim($booking->van->image, '/');
                                    $candidate = strpos($candidate, 'vans/') === 0 ? $candidate : 'vans/' . $candidate;
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($candidate)) {
                                        $firstImage = $candidate;
                                    }
                                }

                                // Fallback to images array
                                if (!$firstImage && is_array($images) && count($images) > 0) {
                                    foreach ($images as $img) {
                                        $candidate = ltrim($img, '/');
                                        $candidate = strpos($candidate, 'vans/') === 0 ? $candidate : 'vans/' . $candidate;
                                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($candidate)) {
                                            $firstImage = $candidate;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}"
                                     alt="{{ $booking->van->name }}"
                                     class="w-20 h-14 object-contain rounded-lg shadow-sm">
                            @else
                                <div class="w-20 h-14 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 text-xs">No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $booking->van->name }}</td>
                        <td class="py-2 px-4">{{ $booking->user->name }}</td>
                        <td class="py-2 px-4">{{ $booking->pickup_location ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ $booking->dropoff_location ?? 'N/A' }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($booking->end_date)->format('Y-m-d') }}</td>
                        <!-- Use total_days directly from DB -->
                        <td class="py-2 px-4">{{ $booking->total_days }}</td>
                        <td class="py-2 px-4">{{ number_format($booking->total_price,2) }}</td>
                        <td class="py-2 px-4">{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                        <td class="py-2 px-4 status-cell" data-booking-id="{{ $booking->id }}">
                            @if($booking->status == 'pending')
                                <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Pending</span>
                            @elseif($booking->status == 'approved')
                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Approved</span>
                            @elseif($booking->status == 'completed')
                                <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded text-sm">Completed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-sm">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                    <!-- Action Buttons Row - Below each booking -->
                    <tr class="border-b bg-gray-50" data-booking-id="{{ $booking->id }}">
                        <td colspan="11" class="py-3 px-4">
                            <div class="flex items-center gap-2 flex-wrap">
                                <!-- View Button -->
                                <button type="button"
                                        data-booking-id="{{ $booking->id }}"
                                        class="view-booking-btn flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </button>

                                <!-- Status Update Buttons -->
                                <button type="button"
                                        data-action-url="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                        data-status="approved"
                                        class="ajax-status-btn flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-check-circle"></i> Approve
                                </button>

                                <button type="button"
                                        data-action-url="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                        data-status="completed"
                                        class="ajax-status-btn flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-clipboard-check"></i> Complete
                                </button>

                                <button type="button"
                                        data-action-url="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                        data-status="pending"
                                        class="ajax-status-btn flex items-center gap-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-clock"></i> Set Pending
                                </button>

                                <button type="button"
                                        data-action-url="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                        data-status="cancelled"
                                        class="ajax-status-btn flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-times-circle"></i> Cancel
                                </button>

                                <!-- Delete Button -->
                                <button type="button"
                                        data-action-url="{{ route('admin.bookings.destroy', $booking->id) }}"
                                        class="ajax-delete-btn flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $bookings->withQueryString()->links() }}
        </div>
        @else
            <p class="text-center text-gray-500 mt-8">No bookings found.</p>
        @endif
    </div>

    <!-- Booking Details Modal -->
    <div id="booking-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-6xl w-full max-h-[95vh] overflow-hidden transform transition-all duration-300 modal-enter">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-white sticky top-0 z-10">
                <h3 class="text-2xl font-bold text-gray-900">Booking Details</h3>
                <button type="button" id="close-modal" class="text-gray-400 hover:text-gray-600 transition p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="overflow-y-auto max-h-[calc(95vh-120px)]">
                <div id="modal-loading" class="flex justify-center items-center py-12">
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                        <p class="text-gray-600">Loading booking details...</p>
                    </div>
                </div>

                <div id="modal-content" class="hidden">
                    <!-- Content will be loaded here via AJAX -->
                </div>

                <div id="modal-error" class="hidden text-center py-12">
                    <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                    <h4 class="text-xl font-semibold text-gray-900 mb-2">Failed to Load Details</h4>
                    <p class="text-gray-600">Unable to load booking details. Please try again.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container for Real-time Notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3"></div>
</x-admin-layout>

<style>
        /* Notification Styles */
    .notification-item {
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        transform: translateX(2px);
    }

    .notification-item.marking-read {
        opacity: 0.6;
        pointer-events: none;
    }

    .notification-item.removing {
        transform: translateX(100%);
        opacity: 0;
        height: 0;
        padding: 0;
        margin: 0;
        overflow: hidden;
    }

    /* Toast Styles */
    .toast {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        max-width: 350px;
        animation: slideIn 0.3s ease-out forwards;
        position: relative;
        overflow: hidden;
    }

    .toast::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
    }

    .toast.booking-notification::before {
        background: linear-gradient(to bottom, #3b82f6, #1d4ed8);
    }

    .toast.success::before {
        background: linear-gradient(to bottom, #10b981, #059669);
    }

    .toast.error::before {
        background: linear-gradient(to bottom, #ef4444, #dc2626);
    }

    .toast.removing {
        animation: slideOut 0.3s ease-in forwards;
    }

    .toast-icon {
        margin-right: 12px;
        flex-shrink: 0;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .toast-message {
        font-size: 13px;
        color: #6b7280;
    }

    .toast-close {
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .toast-close:hover {
        color: #6b7280;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Bell Animation */
    @keyframes bellRing {
        0% { transform: rotate(0); }
        10% { transform: rotate(10deg); }
        20% { transform: rotate(-10deg); }
        30% { transform: rotate(8deg); }
        40% { transform: rotate(-8deg); }
        50% { transform: rotate(6deg); }
        60% { transform: rotate(-6deg); }
        70% { transform: rotate(4deg); }
        80% { transform: rotate(-4deg); }
        90% { transform: rotate(2deg); }
        100% { transform: rotate(0); }
    }

    .bell-ring {
        animation: bellRing 1s ease;
    }

    /* Pulsing green outline for action success (1.5s) */
    .action-success {
        position: relative;
        animation: actionPulse 1.5s ease-in-out forwards;
        box-shadow: 0 0 0 0 rgba(16,185,129,0.0);
    }

    @keyframes actionPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(16,185,129,0.0), 0 0 0 0 rgba(16,185,129,0.0) inset;
        }
        20% {
            box-shadow: 0 0 0 6px rgba(16,185,129,0.12), 0 0 0 0 rgba(16,185,129,0.0) inset;
        }
        60% {
            box-shadow: 0 0 0 10px rgba(16,185,129,0.08), 0 0 0 0 rgba(16,185,129,0.0) inset;
        }
        100% {
            box-shadow: 0 0 0 18px rgba(16,185,129,0.02), 0 0 0 0 rgba(16,185,129,0.0) inset;
        }
    }

    /* Toast styling */
    .ajax-toast-container {
        position: fixed;
        right: 1rem;
        top: 1rem;
        z-index: 9999;
        display:flex;
        flex-direction:column;
        gap:0.5rem;
    }
    .ajax-toast {
        background: #111827;
        color: white;
        padding: 0.6rem 0.9rem;
        border-radius: 0.5rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        font-size: 0.95rem;
        opacity: 0;
        transform: translateY(-6px);
        transition: all 260ms ease;
    }
    .ajax-toast.show {
        opacity: 1;
        transform: translateY(0);
    }
    .ajax-toast.success {
        background: linear-gradient(90deg, #10b981, #059669);
    }
    .ajax-toast.error {
        background: linear-gradient(90deg, #ef4444, #f97316);
    }

    /* Loading state for buttons */
    .btn-loading {
        position: relative;
        pointer-events: none;
        color: transparent !important;
    }
    .btn-loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        margin: -8px 0 0 -8px;
        border: 2px solid currentColor;
        border-radius: 50%;
        border-right-color: transparent;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Modal animations */
    .modal-enter {
        opacity: 0;
        transform: scale(0.95);
    }
    .modal-enter-active {
        opacity: 1;
        transform: scale(1);
        transition: opacity 200ms ease-out, transform 200ms ease-out;
    }

    /* Clean modal styles */
    .modal-content {
        background: white;
    }
</style>

<script>
// Notification System
    document.addEventListener('DOMContentLoaded', function() {
        // Notification dropdown toggle
        const notificationBell = document.getElementById('notification-bell');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const closeNotifications = document.getElementById('close-notifications');
        const notificationCount = document.getElementById('notification-count');

        if (notificationBell && notificationDropdown) {
            notificationBell.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');

                if (!notificationDropdown.classList.contains('hidden')) {
                    // Animate dropdown in
                    setTimeout(() => {
                        notificationDropdown.classList.remove('scale-95', 'opacity-0');
                        notificationDropdown.classList.add('scale-100', 'opacity-100');
                    }, 10);
                } else {
                    notificationDropdown.classList.add('scale-95', 'opacity-0');
                    notificationDropdown.classList.remove('scale-100', 'opacity-100');
                }
            });

            // Close notifications
            if (closeNotifications) {
                closeNotifications.addEventListener('click', function() {
                    notificationDropdown.classList.add('hidden', 'scale-95', 'opacity-0');
                    notificationDropdown.classList.remove('scale-100', 'opacity-100');
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!notificationDropdown.contains(e.target) && !notificationBell.contains(e.target)) {
                    notificationDropdown.classList.add('hidden', 'scale-95', 'opacity-0');
                    notificationDropdown.classList.remove('scale-100', 'opacity-100');
                }
            });
        }

        // Mark notification as read
        document.addEventListener('click', function(e) {
            if (e.target.closest('.mark-read-form')) {
                e.preventDefault();
                const form = e.target.closest('.mark-read-form');
                const notificationItem = form.closest('.notification-item');
                const notificationId = notificationItem.getAttribute('data-notification-id');

                // Mark as reading state
                notificationItem.classList.add('marking-read');

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remove notification with animation
                        notificationItem.classList.add('removing');
                        setTimeout(() => {
                            notificationItem.remove();

                            // Update notification count
                            updateNotificationCount();

                            // Check if no notifications left
                            const notifications = document.querySelectorAll('.notification-item');
                            if (notifications.length === 0) {
                                const notificationList = document.getElementById('notification-list');
                                notificationList.innerHTML = `
                                    <div class="p-4 text-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.24 8.56a5.97 5.97 0 01-4.66-6.24M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>No new notifications</p>
                                    </div>
                                `;
                            }
                        }, 300);
                    } else {
                        notificationItem.classList.remove('marking-read');
                        showToast('Failed to mark notification as read', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notificationItem.classList.remove('marking-read');
                    showToast('Failed to mark notification as read', 'error');
                });
            }
        });

        // Update notification count
        function updateNotificationCount() {
            if (notificationCount) {
                const count = document.querySelectorAll('.notification-item').length;
                if (count > 0) {
                    notificationCount.textContent = count;
                } else {
                    notificationCount.remove();
                }
            }
        }
    });

    // Toast notification function
    function showToast(message, type = 'success', title = null, autoHide = true, duration = 5000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toastId = 'toast-' + Date.now();
        const toast = document.createElement('div');
        toast.id = toastId;

        // Set appropriate title and icon based on type
        let toastTitle = title;
        let iconSvg = '';

        if (type === 'booking-notification') {
            toastTitle = toastTitle || 'New Booking';
            iconSvg = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            `;
        } else if (type === 'success') {
            toastTitle = toastTitle || 'Success';
            iconSvg = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            `;
        } else if (type === 'error') {
            toastTitle = toastTitle || 'Error';
            iconSvg = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            `;
        }

        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">${iconSvg}</div>
            <div class="toast-content">
                <div class="toast-title">${toastTitle}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="removeToast('${toastId}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        `;

        container.appendChild(toast);

        // Auto remove after duration if enabled
        if (autoHide) {
            setTimeout(() => {
                removeToast(toastId);
            }, duration);
        }

        return toastId;
    }

    // Remove toast function
    function removeToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.add('removing');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }
    }

    // Simulate receiving a new booking notification
    function simulateNewBooking() {
        const bookingId = Math.floor(Math.random() * 1000) + 100;
        const message = `New booking #${bookingId} has been created`;

        // Show toast notification
        showToast(message, 'booking-notification', 'New Booking', true, 6000);

        // Animate bell
        const bell = document.getElementById('notification-bell');
        if (bell) {
            bell.classList.add('bell-ring');
            setTimeout(() => {
                bell.classList.remove('bell-ring');
            }, 1000);
        }

        // For demo purposes - in real app, you would fetch actual notification from server
        console.log('New booking notification:', message);
    }

        // Update notification count and list (simulated)
        // In a real app, you would fetch the actual notification from the server
        setTimeout(() => {
            // This would be an AJAX call to get the actual notification in a real app
            const notificationList = document.getElementById('notification-list');
            const emptyState = notificationList.querySelector('.text-center');

            if (emptyState) {
                emptyState.remove();
            }

            const newNotification = document.createElement('div');
            newNotification.className = 'notification-item';
            newNotification.setAttribute('data-notification-id', 'new-' + Date.now());
            newNotification.innerHTML = `
                <div class="p-3 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="h-2 w-2 bg-blue-500 rounded-full animate-pulse"></div>
                                <span class="text-xs text-gray-500">Just now</span>
                            </div>
                            <p class="text-sm text-gray-800">${message}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-xs font-medium text-blue-600">Booking #${bookingId}</span>
                                <button class="text-xs text-green-600 hover:text-green-800 font-medium mark-read-btn">Mark as Read</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            notificationList.insertBefore(newNotification, notificationList.firstChild);

            // Add event listener to the new mark as read button
            newNotification.querySelector('.mark-read-btn').addEventListener('click', function() {
                const notificationItem = this.closest('.notification-item');
                notificationItem.classList.add('removing');
                setTimeout(() => {
                    notificationItem.remove();
                    updateNotificationCount();
                }, 300);
            });

            // Update notification count
            updateNotificationCount();
        }, 500);
    }

    // Demo: Simulate a new booking every 30 seconds (remove in production)
    // setInterval(simulateNewBooking, 30000);

    // For testing: Uncomment the line below to simulate a notification immediately
    // setTimeout(simulateNewBooking, 2000);

    // Rest of your existing JavaScript code for modals, status updates, etc.
    // [Previous JavaScript code for modals, status updates, etc. remains the same]
</script>
