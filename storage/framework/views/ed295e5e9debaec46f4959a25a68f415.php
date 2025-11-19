<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - Booking #<?php echo e($booking->id); ?></title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 30px;
            color: #333;
            line-height: 1.4;
            background: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 25px;
        }
        .company-info {
            margin-bottom: 35px;
            text-align: center;
        }
        .booking-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 35px;
            gap: 20px;
        }
        .info-box {
            flex: 1;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: left;
        }
        .table th {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        .table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .total-section {
            text-align: right;
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .total-amount {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            border-top: 2px solid #e2e8f0;
            padding-top: 25px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
        .status-approved { background: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .status-completed { background: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; }
        .status-cancelled { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        h1 { color: #1e40af; margin: 0 0 10px 0; font-size: 32px; }
        h2 { color: #374151; margin: 0 0 15px 0; font-size: 20px; }
        h3 { color: #3b82f6; margin: 0 0 12px 0; font-size: 18px; }
        h4 { color: #4b5563; margin: 0 0 10px 0; font-size: 16px; }
        .text-muted { color: #6b7280; }
        .text-center { text-align: center; }
        .mb-0 { margin-bottom: 0; }
        .mt-0 { margin-top: 0; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .date-range {
            background: #e0f2fe;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin: 15px 0;
            border-left: 4px solid #0369a1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p class="text-muted mb-0">Booking Reference: #<?php echo e($booking->id); ?></p>
        <p class="text-muted">Issued Date: <?php echo e(now()->format('F d, Y')); ?></p>
    </div>

    <div class="company-info">
        <h2 class="mb-2">VanRental Pro</h2>
        <p class="mb-0">123 Business Avenue, Downtown City</p>
        <p class="mb-0">Phone: (555) 123-4567 | Email: billing@vanrentalpro.com</p>
        <p class="mb-0">Website: www.vanrentalpro.com</p>
    </div>

    <div class="booking-info">
        <div class="info-box">
            <h3>Customer Information</h3>
            <p class="mb-2"><strong>Name:</strong> <?php echo e($booking->user->name); ?></p>
            <p class="mb-2"><strong>Email:</strong> <?php echo e($booking->user->email); ?></p>
            <p class="mb-0"><strong>Customer Since:</strong> <?php echo e($booking->user->created_at->format('M Y')); ?></p>
        </div>

        <div class="info-box">
            <h3>Booking Details</h3>
            <p class="mb-2"><strong>Booking Date:</strong> <?php echo e($booking->created_at->format('M d, Y')); ?></p>
            <p class="mb-2">
                <strong>Status:</strong>
                <span class="status-badge status-<?php echo e($booking->status); ?>">
                    <?php echo e(ucfirst($booking->status)); ?>

                </span>
            </p>
            <p class="mb-0"><strong>Invoice #:</strong> INV-<?php echo e($booking->id); ?>-<?php echo e(date('Y')); ?></p>
        </div>
    </div>

    <div class="date-range">
        <h4 class="mb-2">Rental Period</h4>
        <p class="mb-0">
            <strong><?php echo e(\Carbon\Carbon::parse($booking->start_date)->format('M d, Y')); ?></strong>
            to
            <strong><?php echo e(\Carbon\Carbon::parse($booking->end_date)->format('M d, Y')); ?></strong>
            (<?php echo e($booking->total_days); ?> days)
        </p>
    </div>

    <div style="background: #f0f9ff; padding: 20px; border-radius: 12px; margin-bottom: 25px; border-left: 4px solid #0ea5e9;">
        <h3 class="mb-2">Vehicle Details</h3>
        <p class="mb-2"><strong>Van:</strong> <?php echo e($booking->van->name); ?></p>
        <p class="mb-2"><strong>Model:</strong> <?php echo e($booking->van->model ?? 'Standard Model'); ?></p>
        <p class="mb-0"><strong>Seating Capacity:</strong> <?php echo e($booking->van->seats ?? 'N/A'); ?> passengers</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Van Rental - <?php echo e($booking->van->name); ?></strong><br>
                    <small class="text-muted">
                        <?php echo e($booking->van->model ?? 'Standard Model'); ?> |
                        <?php echo e($booking->total_days); ?> day rental period
                    </small>
                </td>
                <td><?php echo e($booking->total_days); ?> days</td>
                <td>$<?php echo e(number_format($booking->van->price_per_day, 2)); ?>/day</td>
                <td>$<?php echo e(number_format($booking->van->price_per_day * $booking->total_days, 2)); ?></td>
            </tr>

            <?php if($booking->pickup_location): ?>
            <tr>
                <td>
                    <strong>Pickup Service</strong><br>
                    <small class="text-muted">Location: <?php echo e($booking->pickup_location); ?></small>
                </td>
                <td>1 service</td>
                <td>Complimentary</td>
                <td>$0.00</td>
            </tr>
            <?php endif; ?>

            <?php if($booking->dropoff_location): ?>
            <tr>
                <td>
                    <strong>Drop-off Service</strong><br>
                    <small class="text-muted">Location: <?php echo e($booking->dropoff_location); ?></small>
                </td>
                <td>1 service</td>
                <td>Complimentary</td>
                <td>$0.00</td>
            </tr>
            <?php endif; ?>

            <tr>
                <td>
                    <strong>Basic Insurance Coverage</strong><br>
                    <small class="text-muted">Comprehensive protection included</small>
                </td>
                <td><?php echo e($booking->total_days); ?> days</td>
                <td>Included</td>
                <td>$0.00</td>
            </tr>

            <tr style="background: #f1f5f9;">
                <td colspan="3" style="text-align: right; font-weight: bold;">Subtotal</td>
                <td style="font-weight: bold;">$<?php echo e(number_format($booking->van->price_per_day * $booking->total_days, 2)); ?></td>
            </tr>

            <tr>
                <td colspan="3" style="text-align: right;">Tax (10%)</td>
                <td>$<?php echo e(number_format($booking->van->price_per_day * $booking->total_days * 0.1, 2)); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <p class="mb-2" style="font-size: 16px; opacity: 0.9;">Total Amount Due</p>
        <p class="total-amount">$<?php echo e(number_format($booking->total_price, 2)); ?></p>
        <p style="margin: 0; font-size: 14px; opacity: 0.9;">USD</p>
    </div>

    <div class="footer">
        <p><strong>Thank you for your business!</strong></p>
        <p>This is a computer-generated invoice. No signature required.</p>
        <p>Invoice generated on: <?php echo e(now()->format('F d, Y \a\t h:i A')); ?></p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/admin/bookings/invoice-pdf.blade.php ENDPATH**/ ?>