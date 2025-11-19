<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Booking #{{ $booking->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 20px; }
            .print-shadow { box-shadow: none !important; }
        }
        @page { margin: 0; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Print Header -->
    <div class="no-print bg-white shadow-sm border-b p-4 mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Invoice Preview</h1>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-print"></i> Print Invoice
                </button>
                <button onclick="window.close()" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="container mx-auto max-w-4xl bg-white print-shadow rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white p-8 text-center">
            <h1 class="text-4xl font-bold mb-2">INVOICE</h1>
            <p class="text-blue-100 text-lg">Booking Reference: #{{ $booking->id }}</p>
            <p class="text-blue-100">Issued: {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Company & Booking Info -->
        <div class="p-8 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">VanRental Pro</h3>
                    <div class="space-y-2 text-gray-600">
                        <p class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-blue-500"></i>
                            123 Business Avenue, City, State 12345
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-phone text-green-500"></i>
                            (555) 123-4567
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-envelope text-purple-500"></i>
                            billing@vanrentalpro.com
                        </p>
                    </div>
                </div>

                <!-- Booking Info -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Booking Details</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Booking ID:</span>
                            <span class="font-semibold">#{{ $booking->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold capitalize px-3 py-1 rounded-full
                                @if($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'approved') bg-green-100 text-green-800
                                @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $booking->status }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Invoice Date:</span>
                            <span class="font-semibold">{{ now()->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Vehicle Info -->
        <div class="p-8 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Customer Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
                    <div class="space-y-2">
                        <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                        <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                        <p><strong>Customer Since:</strong> {{ $booking->user->created_at->format('M Y') }}</p>
                    </div>
                </div>

                <!-- Vehicle Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Vehicle Information</h3>
                    <div class="space-y-2">
                        <p><strong>Van:</strong> {{ $booking->van->name }}</p>
                        <p><strong>Model:</strong> {{ $booking->van->model ?? 'Standard Model' }}</p>
                        <p><strong>Seats:</strong> {{ $booking->van->seats ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Period -->
        <div class="p-8 border-b border-gray-200 bg-blue-50">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Rental Period</h3>
            <div class="flex justify-center items-center gap-8">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Start Date</p>
                    <p class="text-xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-arrow-right text-2xl"></i>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Return Date</p>
                    <p class="text-xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>
                </div>
                <div class="text-center ml-8">
                    <p class="text-sm text-gray-600">Total Days</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $booking->total_days }} Days</p>
                </div>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="p-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Invoice Details</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-6 py-4 text-left font-semibold text-gray-700">Description</th>
                            <th class="border border-gray-300 px-6 py-4 text-center font-semibold text-gray-700">Days</th>
                            <th class="border border-gray-300 px-6 py-4 text-right font-semibold text-gray-700">Unit Price</th>
                            <th class="border border-gray-300 px-6 py-4 text-right font-semibold text-gray-700">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Main Rental -->
                        <tr>
                            <td class="border border-gray-300 px-6 py-4">
                                <strong>Van Rental - {{ $booking->van->name }}</strong>
                                <p class="text-sm text-gray-600 mt-1">{{ $booking->van->model ?? 'Standard Model' }}</p>
                            </td>
                            <td class="border border-gray-300 px-6 py-4 text-center">{{ $booking->total_days }}</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">${{ number_format($booking->van->price_per_day, 2) }}/day</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">${{ number_format($booking->van->price_per_day * $booking->total_days, 2) }}</td>
                        </tr>

                        <!-- Pickup Service -->
                        @if($booking->pickup_location)
                        <tr>
                            <td class="border border-gray-300 px-6 py-4">
                                <strong>Pickup Service</strong>
                                <p class="text-sm text-gray-600 mt-1">Location: {{ $booking->pickup_location }}</p>
                            </td>
                            <td class="border border-gray-300 px-6 py-4 text-center">-</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">Complimentary</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">$0.00</td>
                        </tr>
                        @endif

                        <!-- Drop-off Service -->
                        @if($booking->dropoff_location)
                        <tr>
                            <td class="border border-gray-300 px-6 py-4">
                                <strong>Drop-off Service</strong>
                                <p class="text-sm text-gray-600 mt-1">Location: {{ $booking->dropoff_location }}</p>
                            </td>
                            <td class="border border-gray-300 px-6 py-4 text-center">-</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">Complimentary</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">$0.00</td>
                        </tr>
                        @endif

                        <!-- Subtotal -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="border border-gray-300 px-6 py-4 text-right font-semibold">Subtotal</td>
                            <td class="border border-gray-300 px-6 py-4 text-right font-semibold">${{ number_format($booking->van->price_per_day * $booking->total_days, 2) }}</td>
                        </tr>

                        <!-- Tax -->
                        <tr>
                            <td colspan="3" class="border border-gray-300 px-6 py-4 text-right">Tax (10%)</td>
                            <td class="border border-gray-300 px-6 py-4 text-right">${{ number_format($booking->van->price_per_day * $booking->total_days * 0.1, 2) }}</td>
                        </tr>

                        <!-- Total -->
                        <tr class="bg-green-50">
                            <td colspan="3" class="border border-gray-300 px-6 py-4 text-right font-bold text-lg">TOTAL AMOUNT</td>
                            <td class="border border-gray-300 px-6 py-4 text-right font-bold text-lg text-green-600">${{ number_format($booking->total_price, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-900 text-white p-8 text-center">
            <h3 class="text-lg font-semibold mb-4">Thank you for your business!</h3>
            <p class="text-gray-300 mb-2">This is a computer-generated invoice. No signature required.</p>
            <p class="text-gray-400 text-sm">Invoice generated on: {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>

    <script>
        // Auto-print when page loads (optional)
        window.onload = function() {
            // Uncomment the line below if you want auto-print
            // window.print();
        };
    </script>
</body>
</html>
