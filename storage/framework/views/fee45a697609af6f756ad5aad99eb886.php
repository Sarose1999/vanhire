<div class="min-h-screen bg-gray-50 py-4" data-booking-id="<?php echo e($booking->id); ?>">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

                <!-- ====================== -->
                <!--    VAN IMAGE DISPLAY   -->
                <!-- ====================== -->
                <?php
                    use Illuminate\Support\Facades\Storage;
                    use Illuminate\Support\Str;

                    function resolveVanImage($booking) {
                        $resolve = function ($file) {
                            if (!$file) return null;
                            $path = Str::startsWith($file, 'vans/')
                                        ? $file
                                        : 'vans/' . ltrim($file, '/');

                            return Storage::disk('public')->exists($path) ? $path : null;
                        };

                        // Main image
                        if (!empty($booking->van->image)) {
                            $img = $resolve($booking->van->image);
                            if ($img) return $img;
                        }

                        // Gallery images
                        if (!empty($booking->van->images)) {
                            $images = $booking->van->images;
                            if (is_string($images)) {
                                $decoded = json_decode($images, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $images = $decoded;
                                } else {
                                    $images = array_filter(array_map('trim', explode(',', $images)));
                                }
                            }

                            if (is_array($images)) {
                                foreach ($images as $i) {
                                    $img = $resolve($i);
                                    if ($img) return $img;
                                }
                            }
                        }

                        return null;
                    }

                    $firstImage = resolveVanImage($booking);
                ?>

                <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 h-80 overflow-hidden">
                    <?php if($firstImage): ?>
                        <img src="<?php echo e(asset('storage/' . $firstImage)); ?>"
                             alt="<?php echo e($booking->van->name); ?>"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        <div class="absolute top-4 left-4">
                            <span class="bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Van ID: <?php echo e($booking->van->id); ?>

                            </span>
                        </div>
                    <?php else: ?>
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-shuttle-van text-2xl"></i>
                            </div>
                            <p class="text-lg font-medium">No Image Available</p>
                            <p class="text-sm mt-1"><?php echo e($booking->van->name); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ====================== -->
                <!--       CONTENT GRID     -->
                <!-- ====================== -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">

                    <!-- LEFT SIDE -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Van Info -->
                        <div class="animate-fade-in" style="animation-delay: 0.1s">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-shuttle-van text-blue-600"></i>
                                </div>
                                Van Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-tag text-blue-500 mr-2 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-600">Van Name</span>
                                    </div>
                                    <p class="font-semibold text-gray-800 text-lg"><?php echo e($booking->van->name); ?></p>
                                </div>

                                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-dollar-sign text-green-500 mr-2 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-600">Price/Day</span>
                                    </div>
                                    <p class="font-semibold text-green-600 text-lg">$<?php echo e(number_format($booking->van->price_per_day, 2)); ?></p>
                                </div>

                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-users text-purple-500 mr-2 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-600">Seats</span>
                                    </div>
                                    <p class="font-semibold text-gray-800 text-lg"><?php echo e($booking->van->seats ?? 'N/A'); ?></p>
                                </div>

                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-xl border border-orange-200">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-cog text-orange-500 mr-2 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-600">Model</span>
                                    </div>
                                    <p class="font-semibold text-gray-800 text-lg"><?php echo e($booking->van->model ?? 'N/A'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="animate-fade-in" style="animation-delay: 0.2s">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                Customer Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-4 rounded-xl border border-green-200 transform transition-all duration-300 hover:scale-105">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-user-circle text-green-500 mr-2 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-600">Customer Name</span>
                                    </div>
                                    <p class="font-semibold text-gray-800 text-lg"><?php echo e($booking->user->name); ?></p>
                                </div>

                                <div class="bg-gradient-to-br from-blue-50 to-cyan-100 p-4 rounded-xl border border-blue-200 transform transition-all duration-300 hover:scale-105">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-envelope text-blue-500 mr-2 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-600">Email</span>
                                    </div>
                                    <p class="font-semibold text-gray-800 text-lg break-all"><?php echo e($booking->user->email); ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT SIDE → Booking Summary -->
                    <div class="animate-fade-in" style="animation-delay: 0.3s">
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-100 p-6 rounded-xl shadow-sm border border-purple-200 h-full">

                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-check text-purple-600"></i>
                                </div>
                                Booking Summary
                            </h2>

                            <!-- Status Badge -->
                            <div class="text-center mb-6">
                                <?php if($booking->status == 'pending'): ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 animate-pulse">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-ping"></span>
                                        Pending Approval
                                    </span>
                                <?php elseif($booking->status == 'approved'): ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Approved
                                    </span>
                                <?php elseif($booking->status == 'completed'): ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        Completed
                                    </span>
                                <?php elseif($booking->status == 'cancelled'): ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                        Cancelled
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Booking Details -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-purple-200">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-play-circle text-green-500 mr-2"></i>
                                        <span>Start Date</span>
                                    </div>
                                    <span class="font-semibold text-gray-800">
                                        <?php echo e(\Carbon\Carbon::parse($booking->start_date)->format('M d, Y')); ?>

                                    </span>
                                </div>

                                <div class="flex justify-between items-center py-3 border-b border-purple-200">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-flag-checkered text-red-500 mr-2"></i>
                                        <span>Return Date</span>
                                    </div>
                                    <span class="font-semibold text-gray-800">
                                        <?php echo e(\Carbon\Carbon::parse($booking->end_date)->format('M d, Y')); ?>

                                    </span>
                                </div>

                                <div class="flex justify-between items-center py-3 border-b border-purple-200">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                                        <span>Total Days</span>
                                    </div>
                                    <span class="font-semibold text-blue-600 text-lg">
                                        <?php echo e($booking->total_days); ?> Days
                                    </span>
                                </div>

                                <div class="flex justify-between items-center py-3 border-b border-purple-200">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i>
                                        <span>Pickup Location</span>
                                    </div>
                                    <span class="font-semibold text-gray-800 text-right max-w-[120px]"><?php echo e($booking->pickup_location ?? 'Not specified'); ?></span>
                                </div>

                                <div class="flex justify-between items-center py-3 border-b border-purple-200">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker text-orange-500 mr-2"></i>
                                        <span>Drop-off Location</span>
                                    </div>
                                    <span class="font-semibold text-gray-800 text-right max-w-[120px]"><?php echo e($booking->dropoff_location ?? 'Not specified'); ?></span>
                                </div>

                                <div class="flex justify-between items-center pt-4 border-t border-purple-300">
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-receipt text-green-500 mr-2 text-lg"></i>
                                        <span class="text-lg font-bold">Total Price</span>
                                    </div>
                                    <span class="text-2xl font-bold text-green-600">
                                        $<?php echo e(number_format($booking->total_price, 2)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ====================== -->
                <!--     ACTION BUTTONS    -->
                <!-- ====================== -->
                <div class="bg-gray-50 p-6 border-t border-gray-200 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

                        <!-- Left: Invoice & Edit -->
                        <div class="flex flex-wrap gap-3">
                            <a href="<?php echo e(route('admin.bookings.invoice', $booking->id)); ?>"
                               target="_blank"
                               class="group bg-white border border-indigo-300 text-indigo-600 px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-indigo-50 transition-all duration-300 hover:shadow-md font-medium">
                                <i class="fas fa-print group-hover:scale-110 transition-transform"></i>
                                Print Invoice
                            </a>

                            <a href="<?php echo e(route('admin.bookings.download', $booking->id)); ?>"
                               class="group bg-indigo-500 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-indigo-600 transition-all duration-300 hover:shadow-md font-medium transform hover:scale-105">
                                <i class="fas fa-download group-hover:scale-110 transition-transform"></i>
                                Download Invoice
                            </a>

                            <a href="<?php echo e(route('admin.vans.edit', $booking->van->id)); ?>"
                               class="group bg-yellow-500 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-yellow-600 transition-all duration-300 hover:shadow-md font-medium transform hover:scale-105">
                                <i class="fas fa-edit group-hover:scale-110 transition-transform"></i>
                                Edit Van
                            </a>
                        </div>

                        <!-- Right: Status Buttons -->
                        

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out both;
    }

    .ajax-status-btn:disabled,
    .ajax-delete-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }
</style>

<script>
    // Handle status update buttons in modal
    document.addEventListener('click', function(e) {
        const modalContent = document.getElementById('modal-content');
        if (!modalContent.contains(e.target)) return;

        // Status update buttons
        if (e.target.classList.contains('ajax-status-btn')) {
            const button = e.target;
            const actionUrl = button.getAttribute('data-action-url');
            const status = button.getAttribute('data-status');
            const bookingId = document.querySelector('[data-booking-id]').getAttribute('data-booking-id');

            // Show confirmation for destructive actions
            if (status === 'cancelled') {
                if (!confirm('Are you sure you want to cancel this booking?')) return;
            }
            if (status === 'pending') {
                if (!confirm('Reset this booking to pending status?')) return;
            }

            updateBookingStatus(button, actionUrl, status, bookingId);
        }

        // Delete button
        if (e.target.classList.contains('ajax-delete-btn')) {
            const button = e.target;
            const actionUrl = button.getAttribute('data-action-url');
            const bookingId = document.querySelector('[data-booking-id]').getAttribute('data-booking-id');

            if (confirm('Are you sure you want to delete this booking? This action cannot be undone.')) {
                deleteBooking(button, actionUrl, bookingId);
            }
        }
    });

    function updateBookingStatus(button, actionUrl, status, bookingId) {
        // Add loading state
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        button.disabled = true;

        // Create form data
        const formData = new FormData();
        formData.append('_token', '<?php echo e(csrf_token()); ?>');
        formData.append('_method', 'PATCH');
        formData.append('status', status);

        fetch(actionUrl, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Status updated successfully!', 'success');
                } else {
                    alert(data.message || 'Status updated successfully!');
                }

                // Reload modal content to reflect changes
                setTimeout(() => {
                    const viewBtn = document.querySelector(`.view-booking-btn[data-booking-id="${bookingId}"]`);
                    if (viewBtn) {
                        viewBtn.click(); // Trigger the view button to reload modal
                    }
                }, 1000);

            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast(error.message || 'Failed to update status. Please try again.', 'error');
            } else {
                alert(error.message || 'Failed to update status. Please try again.');
            }
        })
        .finally(() => {
            // Restore button
            button.innerHTML = originalHTML;
            button.disabled = false;
        });
    }

    function deleteBooking(button, actionUrl, bookingId) {
        // Add loading state
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
        button.disabled = true;

        // Create form data
        const formData = new FormData();
        formData.append('_token', '<?php echo e(csrf_token()); ?>');
        formData.append('_method', 'DELETE');

        fetch(actionUrl, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast('Booking deleted successfully!', 'success');
                } else {
                    alert('Booking deleted successfully!');
                }

                // Close modal and remove from table
                setTimeout(() => {
                    if (typeof closeModal === 'function') {
                        closeModal();
                    }
                    // Remove booking from table
                    const rows = document.querySelectorAll(`tr[data-booking-id="${bookingId}"]`);
                    rows.forEach(row => row.remove());
                }, 1000);

            } else {
                throw new Error(data.message || 'Failed to delete booking');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast(error.message || 'Failed to delete booking. Please try again.', 'error');
            } else {
                alert(error.message || 'Failed to delete booking. Please try again.');
            }
        })
        .finally(() => {
            // Restore button
            button.innerHTML = originalHTML;
            button.disabled = false;
        });
    }
</script>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/admin/bookings/partials/modal-content.blade.php ENDPATH**/ ?>