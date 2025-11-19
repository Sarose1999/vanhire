<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo e($van->name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .booking-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin: 2rem 0;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e1e5ee;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .input-group-text {
            background-color: #f1f3f9;
            border: 1px solid #e1e5ee;
            border-radius: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }

        .price-display {
            background-color: #f8f9ff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .price-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
        }

        .van-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: var(--border-radius);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eaeaea;
        }

        .location-inputs {
            position: relative;
        }

        .location-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 5;
        }

        .location-input {
            padding-left: 45px;
        }

        .date-inputs {
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .date-inputs {
                flex-direction: column;
                gap: 0;
            }
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="booking-card">
                    <div class="card-header text-center text-white">
                        <h2 class="mb-0"><i class="fas fa-van-shuttle me-2"></i>Book <?php echo e($van->name); ?></h2>
                        <p class="mb-0 mt-2 opacity-75">Complete your booking details below</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('bookings.store', $van->id)); ?>" id="bookingForm">
                            <?php echo csrf_field(); ?>

                            <?php if(session('error')): ?>
                                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                            <?php endif; ?>

                            <div class="row">
                                <!-- Left Column - Van Info and Locations -->
                                <div class="col-md-6">
                                    <!-- Van Information -->
                                    <div class="mb-4">
                                        <div class="section-title">
                                            <i class="fas fa-info-circle me-2"></i>Van Information
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="feature-icon">
                                                <i class="fas fa-caravan"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0"><?php echo e($van->name); ?></h5>
                                                <p class="text-muted mb-0">Comfortable and reliable transport</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><i class="fas fa-dollar-sign text-muted me-2"></i>Price per day:</span>
                                            <span class="fw-bold">$<?php echo e($van->price_per_day); ?></span>
                                        </div>
                                    </div>

                                    <!-- Location Details -->
                                    <div class="mb-4">
                                        <div class="section-title">
                                            <i class="fas fa-map-marker-alt me-2"></i>Location Details
                                        </div>

                                        <div class="location-inputs mb-3">
                                            <i class="fas fa-map-pin location-icon"></i>
                                            <input type="text" class="form-control location-input" name="pickup_location" id="pickup_location" placeholder="Enter pick-up location" required>
                                        </div>

                                        <div class="location-inputs">
                                            <i class="fas fa-flag-checkered location-icon"></i>
                                            <input type="text" class="form-control location-input" name="dropoff_location" id="dropoff_location" placeholder="Enter drop-off location" required>
                                        </div>
                                    </div>

                                    <!-- Date & Time Selection -->
                                    <div class="mb-4">
                                        <div class="section-title">
                                            <i class="far fa-calendar-alt me-2"></i>Date & Time
                                        </div>

                                        <div class="date-inputs">
                                            <div class="mb-3 flex-fill">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" id="start_date" required>
                                            </div>

                                            <div class="mb-3 flex-fill">
                                                <label for="end_date" class="form-label">Return Date</label>
                                                <input type="date" class="form-control" name="end_date" id="end_date" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="time" class="form-label">Pick-up Time</label>
                                            <input type="time" class="form-control" name="time" id="time" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Pricing and Summary -->
                                <div class="col-md-6">
                                    <!-- Pricing Summary -->
                                    <div class="price-display">
                                        <div class="section-title">
                                            <i class="fas fa-receipt me-2"></i>Booking Summary
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Total Days:</span>
                                            <span class="fw-bold" id="total_days_display">0</span>
                                            <input type="hidden" id="total_days" readonly>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Price per Day:</span>
                                            <span class="fw-bold">$<?php echo e($van->price_per_day); ?></span>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Total Price:</span>
                                            <span class="price-value" id="total_price_display">$0.00</span>
                                            <input type="hidden" id="total_price" readonly>
                                        </div>
                                    </div>

                                    <!-- Availability Status -->
                                    <div id="availabilityMessage" class="mt-4" style="display:none;"></div>

                                    <!-- Action Buttons -->
                                    <div class="mt-4">
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary flex-fill py-3">
                                                <i class="fas fa-arrow-left me-2"></i>Back
                                            </a>
                                            <button type="submit" class="btn btn-primary flex-fill py-3">
                                                <i class="fas fa-check-circle me-2"></i>Complete Booking
                                            </button>
                                        </div>
                                        <p class="text-muted text-center mt-2 small">
                                            <i class="fas fa-lock me-1"></i>Your information is secure
                                        </p>
                                    </div>

                                    <!-- Additional Info -->
                                    <div class="mt-4">
                                        <div class="d-flex">
                                            <div class="feature-icon">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">Fully Insured</h6>
                                                <p class="text-muted small mb-0">Comprehensive coverage for your peace of mind</p>
                                            </div>
                                        </div>

                                        <div class="d-flex mt-3">
                                            <div class="feature-icon">
                                                <i class="fas fa-headset"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">24/7 Support</h6>
                                                <p class="text-muted small mb-0">Our team is always here to help you</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const totalDaysDisplay = document.getElementById('total_days_display');
            const totalDays = document.getElementById('total_days');
            const totalPriceDisplay = document.getElementById('total_price_display');
            const totalPrice = document.getElementById('total_price');
            const vanPrice = <?php echo e($van->price_per_day); ?>;

            // Set minimum date to today for both start and end dates
            const today = new Date().toISOString().split('T')[0];
            startDate.min = today;
            endDate.min = today;

            function calculateDaysAndPrice() {
                if (startDate.value && endDate.value) {
                    const start = new Date(startDate.value);
                    const end = new Date(endDate.value);

                    // Validate dates
                    if (end < start) {
                        alert("⚠️ Return date cannot be earlier than start date.");
                        endDate.value = '';
                        totalDaysDisplay.textContent = '0';
                        totalDays.value = '';
                        totalPriceDisplay.textContent = '$0.00';
                        totalPrice.value = '';
                        return;
                    }

                    // Calculate day difference (inclusive)
                    const diffTime = end.getTime() - start.getTime();
                    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

                    // Set totals
                    totalDaysDisplay.textContent = diffDays;
                    totalDays.value = diffDays;
                    totalPriceDisplay.textContent = '$' + (diffDays * vanPrice).toFixed(2);
                    totalPrice.value = (diffDays * vanPrice).toFixed(2);
                } else {
                    totalDaysDisplay.textContent = '0';
                    totalDays.value = '';
                    totalPriceDisplay.textContent = '$0.00';
                    totalPrice.value = '';
                }
            }

            // Update end date minimum when start date changes
            startDate.addEventListener('change', function() {
                endDate.min = this.value;
                if (endDate.value && endDate.value < this.value) {
                    endDate.value = '';
                    totalDaysDisplay.textContent = '0';
                    totalDays.value = '';
                    totalPriceDisplay.textContent = '$0.00';
                    totalPrice.value = '';
                }
                calculateDaysAndPrice();
                checkAvailabilityDebounced();
            });

            endDate.addEventListener('change', function() {
                calculateDaysAndPrice();
                checkAvailabilityDebounced();
            });

            // Availability check
            let availabilityTimer = null;
            function checkAvailabilityDebounced() {
                if (availabilityTimer) clearTimeout(availabilityTimer);
                availabilityTimer = setTimeout(checkAvailability, 500);
            }

            async function checkAvailability() {
                const availEl = document.getElementById('availabilityMessage');
                availEl.style.display = 'none';
                availEl.className = '';

                if (!startDate.value || !endDate.value) return;

                const url = '<?php echo e(route('bookings.checkAvailability', $van->id)); ?>' +
                    '?start_date=' + encodeURIComponent(startDate.value) +
                    '&end_date=' + encodeURIComponent(endDate.value);

                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) throw new Error('Network response was not ok');
                    const json = await res.json();

                    if (json.available) {
                        availEl.style.display = 'block';
                        availEl.className = 'alert alert-success';
                        availEl.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + (json.message || 'Van is available for the selected dates.');
                        document.querySelector('button[type="submit"]').disabled = false;
                    } else {
                        availEl.style.display = 'block';
                        availEl.className = 'alert alert-danger';
                        availEl.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + (json.message || 'Van not available for selected dates.');
                        document.querySelector('button[type="submit"]').disabled = true;
                    }
                } catch (err) {
                    console.error(err);
                }
            }

            // Form submission validation
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                if (startDate.value && endDate.value) {
                    const start = new Date(startDate.value);
                    const end = new Date(endDate.value);

                    if (end < start) {
                        e.preventDefault();
                        alert("❌ Please check your dates. Return date cannot be earlier than start date.");
                        return false;
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/bookings/create.blade.php ENDPATH**/ ?>