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

    <div class="container mx-auto max-w-4xl bg-white print-shadow rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white p-8 text-center">
            <h1 class="text-4xl font-bold mb-2">INVOICE</h1>
            <p class="text-blue-100 text-lg">Booking Reference: #{{ $booking->id }}</p>
            <p class="text-blue-100">Issued: {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Add the rest of the invoice HTML content from the previous example -->
        <!-- ... [include the same content structure as the PDF version] ... -->

    </div>

    <script>
        window.onload = function() {
            // Optional: Auto-print when page loads
            // window.print();
        };
    </script>
</body>
</html>
