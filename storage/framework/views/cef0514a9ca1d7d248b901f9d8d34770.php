<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container mx-auto mt-6">
        <h1 class="text-3xl font-bold mb-6">Manage Bookings</h1>

        <!-- Search + Export -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search bookings..." class="border px-3 py-2 rounded w-full md:w-64">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Search</button>
            </form>

            <a href="<?php echo e(route('admin.bookings.export', ['search' => request('search')])); ?>"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition whitespace-nowrap">
                Export Excel
            </a>
        </div>

        <!-- Bookings Table -->
        <?php if($bookings->count() > 0): ?>
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
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b hover:bg-gray-100" data-booking-id="<?php echo e($booking->id); ?>">
                        <!-- Van Image -->
                        <td class="py-2 px-4">
                            <?php
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
                            ?>

                            <?php if($firstImage): ?>
                                <img src="<?php echo e(asset('storage/' . $firstImage)); ?>"
                                     alt="<?php echo e($booking->van->name); ?>"
                                     class="w-20 h-14 object-contain rounded-lg shadow-sm">
                            <?php else: ?>
                                <div class="w-20 h-14 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 text-xs">No Image</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4"><?php echo e($booking->van->name); ?></td>
                        <td class="py-2 px-4"><?php echo e($booking->user->name); ?></td>
                        <td class="py-2 px-4"><?php echo e($booking->pickup_location ?? 'N/A'); ?></td>
                        <td class="py-2 px-4"><?php echo e($booking->dropoff_location ?? 'N/A'); ?></td>
                        <td class="py-2 px-4"><?php echo e(\Carbon\Carbon::parse($booking->start_date)->format('Y-m-d')); ?></td>
                        <td class="py-2 px-4"><?php echo e(\Carbon\Carbon::parse($booking->end_date)->format('Y-m-d')); ?></td>
                        <!-- Use total_days directly from DB -->
                        <td class="py-2 px-4"><?php echo e($booking->total_days); ?></td>
                        <td class="py-2 px-4"><?php echo e(number_format($booking->total_price,2)); ?></td>
                        <td class="py-2 px-4"><?php echo e($booking->created_at->format('Y-m-d H:i')); ?></td>
                        <td class="py-2 px-4 status-cell" data-booking-id="<?php echo e($booking->id); ?>">
                            <?php if($booking->status == 'pending'): ?>
                                <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Pending</span>
                            <?php elseif($booking->status == 'approved'): ?>
                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Approved</span>
                            <?php elseif($booking->status == 'completed'): ?>
                                <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded text-sm">Completed</span>
                            <?php elseif($booking->status == 'cancelled'): ?>
                                <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-sm">Cancelled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <!-- Action Buttons Row - Below each booking -->
                    <tr class="border-b bg-gray-50" data-booking-id="<?php echo e($booking->id); ?>">
                        <td colspan="11" class="py-3 px-4">
                            <div class="flex items-center gap-2 flex-wrap">
                                <!-- View Button -->
                                <button type="button"
                                        data-booking-id="<?php echo e($booking->id); ?>"
                                        class="view-booking-btn flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </button>

                                <!-- Status Update Buttons -->
                                <button type="button"
                                        data-action-url="<?php echo e(route('admin.bookings.updateStatus', $booking->id)); ?>"
                                        data-status="approved"
                                        class="ajax-status-btn flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-check-circle"></i> Approve
                                </button>

                                <button type="button"
                                        data-action-url="<?php echo e(route('admin.bookings.updateStatus', $booking->id)); ?>"
                                        data-status="completed"
                                        class="ajax-status-btn flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-clipboard-check"></i> Complete
                                </button>

                                <button type="button"
                                        data-action-url="<?php echo e(route('admin.bookings.updateStatus', $booking->id)); ?>"
                                        data-status="pending"
                                        class="ajax-status-btn flex items-center gap-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-clock"></i> Set Pending
                                </button>

                                <button type="button"
                                        data-action-url="<?php echo e(route('admin.bookings.updateStatus', $booking->id)); ?>"
                                        data-status="cancelled"
                                        class="ajax-status-btn flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-times-circle"></i> Cancel
                                </button>

                                <!-- Delete Button -->
                                <button type="button"
                                        data-action-url="<?php echo e(route('admin.bookings.destroy', $booking->id)); ?>"
                                        class="ajax-delete-btn flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-full shadow transition text-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($bookings->withQueryString()->links()); ?>

        </div>
        <?php else: ?>
            <p class="text-center text-gray-500 mt-8">No bookings found.</p>
        <?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>

<style>
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
    // Simple toast utility
    function showToast(message, type = 'success', timeout = 3000) {
        let container = document.querySelector('.ajax-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'ajax-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'ajax-toast ' + (type === 'error' ? 'error' : 'success');
        toast.textContent = message;
        container.appendChild(toast);

        // show
        requestAnimationFrame(() => toast.classList.add('show'));

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, timeout);
    }

    // Status badges mapping
    const statusBadges = {
        pending: '<span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Pending</span>',
        approved: '<span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Approved</span>',
        completed: '<span class="bg-blue-200 text-blue-800 px-2 py-1 rounded text-sm">Completed</span>',
        cancelled: '<span class="bg-red-200 text-red-800 px-2 py-1 rounded text-sm">Cancelled</span>'
    };

    // Modal functionality
    const modal = document.getElementById('booking-modal');
    const closeModalBtn = document.getElementById('close-modal');
    const modalLoading = document.getElementById('modal-loading');
    const modalContent = document.getElementById('modal-content');
    const modalError = document.getElementById('modal-error');

    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Trigger animation
        setTimeout(() => {
            modal.querySelector('.modal-enter').classList.add('modal-enter-active');
        }, 10);
    }

    function closeModal() {
        modal.querySelector('.modal-enter').classList.remove('modal-enter-active');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            modalContent.classList.add('hidden');
            modalError.classList.add('hidden');
            modalLoading.classList.remove('hidden');
            modalContent.innerHTML = '';
        }, 200);
    }

    // Close modal events
    closeModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Handle view booking details
    document.addEventListener('click', function(e) {
        // View booking buttons
        if (e.target.classList.contains('view-booking-btn')) {
            const button = e.target;
            const bookingId = button.getAttribute('data-booking-id');
            loadBookingDetails(bookingId);
        }

        // Status update buttons
        if (e.target.classList.contains('ajax-status-btn')) {
            const button = e.target;
            const actionUrl = button.getAttribute('data-action-url');
            const status = button.getAttribute('data-status');
            const bookingId = button.closest('tr').getAttribute('data-booking-id');

            // Show confirmation for certain status changes
            if (status === 'cancelled') {
                if (!confirm('Are you sure you want to cancel this booking?')) {
                    return;
                }
            }

            updateBookingStatus(button, actionUrl, status, bookingId);
        }

        // Delete buttons
        if (e.target.classList.contains('ajax-delete-btn')) {
            const button = e.target;
            const actionUrl = button.getAttribute('data-action-url');
            const bookingId = button.closest('tr').getAttribute('data-booking-id');

            if (confirm('Are you sure you want to delete this booking?')) {
                deleteBooking(button, actionUrl, bookingId);
            }
        }
    });

    function loadBookingDetails(bookingId) {
        openModal();

        // Show loading state
        modalLoading.classList.remove('hidden');
        modalContent.classList.add('hidden');
        modalError.classList.add('hidden');

        // Fetch booking details - request modal version
        fetch(`/admin/bookings/${bookingId}?modal=true`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load booking details');
            }
            return response.text();
        })
        .then(html => {
            modalLoading.classList.add('hidden');
            modalContent.innerHTML = html;
            modalContent.classList.remove('hidden');

            // Attach event listeners to modal forms
            attachModalFormListeners();
        })
        .catch(error => {
            console.error('Error loading booking details:', error);
            modalLoading.classList.add('hidden');
            modalError.classList.remove('hidden');
        });
    }

    function attachModalFormListeners() {
        // Handle form submissions within the modal
        const modalForms = modalContent.querySelectorAll('form');
        modalForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const action = this.getAttribute('action');
                const method = this.querySelector('input[name="_method"]')?.value || 'POST';

                // For delete forms, show confirmation
                if (method === 'DELETE') {
                    if (!confirm('Are you sure you want to delete this booking?')) {
                        return;
                    }
                }

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        if (method === 'DELETE') {
                            showToast('Booking deleted successfully!', 'success');
                            closeModal();
                            // Remove the booking from the table
                            const rows = document.querySelectorAll(`tr[data-booking-id="${this.closest('[data-booking-id]')?.getAttribute('data-booking-id')}"]`);
                            rows.forEach(row => row.remove());
                        } else {
                            showToast('Booking updated successfully!', 'success');
                            // Reload the modal content to reflect changes
                            const bookingId = this.closest('[data-booking-id]')?.getAttribute('data-booking-id');
                            if (bookingId) {
                                loadBookingDetails(bookingId);
                            }
                        }
                    } else {
                        throw new Error('Action failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Action failed. Please try again.', 'error');
                });
            });
        });
    }

    function updateBookingStatus(button, actionUrl, status, bookingId) {
        // Add loading state
        const originalHTML = button.innerHTML;
        button.classList.add('btn-loading');
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
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // If not JSON, assume success for redirect responses
                return { success: true, status: status };
            }
        })
        .then(data => {
            if (data.success || data.status) {
                // Update status badge
                const statusCell = document.querySelector(`.status-cell[data-booking-id="${bookingId}"]`);
                if (statusCell && statusBadges[status]) {
                    statusCell.innerHTML = statusBadges[status];
                }

                // Show success animation
                const dataRow = document.querySelector(`tr[data-booking-id="${bookingId}"]`);
                if (dataRow) {
                    dataRow.classList.add('action-success');
                    setTimeout(() => dataRow.classList.remove('action-success'), 1500);
                }

                showToast('Status updated successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Failed to update status. Please try again.', 'error');
        })
        .finally(() => {
            // Restore button
            button.classList.remove('btn-loading');
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }

    function deleteBooking(button, actionUrl, bookingId) {
        // Add loading state
        const originalHTML = button.innerHTML;
        button.classList.add('btn-loading');
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
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json();
            } else {
                // If not JSON, assume success for redirect responses
                return { success: true, deleted: true };
            }
        })
        .then(data => {
            if (data.success || data.deleted) {
                // Remove booking rows
                const rows = document.querySelectorAll(`tr[data-booking-id="${bookingId}"]`);
                rows.forEach(row => {
                    row.style.opacity = '0';
                    row.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => row.remove(), 300);
                });

                showToast('Booking deleted successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to delete booking');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Failed to delete booking. Please try again.', 'error');
        })
        .finally(() => {
            // Restore button
            button.classList.remove('btn-loading');
            button.disabled = false;
            button.innerHTML = originalHTML;
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
</script>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>