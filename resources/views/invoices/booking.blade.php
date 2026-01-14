<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'serif'; color: #1a1a1a; }
        .header { text-align: center; margin-bottom: 50px; }
        .details { width: 100%; margin-bottom: 40px; }
        .item-table { width: 100%; border-collapse: collapse; }
        .item-table th { text-align: left; border-bottom: 2px solid #f4f4f4; padding: 10px; }
        .item-table td { padding: 10px; border-bottom: 1px solid #f4f4f4; }
        .total { text-align: right; margin-top: 30px; font-size: 20px; font-weight: bold; }
        .status-badge { color: green; text-transform: uppercase; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ECOLUXE</h1>
        <p>Service Invoice</p>
    </div>

    <table class="details">
        <tr>
            <td><strong>Customer:</strong> {{ $booking->customer_name }}</td>
            <td style="text-align: right;"><strong>Date:</strong> {{ $booking->created_at->format('M j, Y') }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong> {{ $booking->customer_email }}</td>
            <td style="text-align: right;"><strong>Invoice #:</strong> {{ $booking->id }}</td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->service->name }} ({{ $booking->total_rooms }} Rooms)</td>
                <td style="text-align: right;">${{ number_format($booking->subtotal, 2) }}</td>
            </tr>
            @if($booking->discount_amount > 0)
            <tr>
                <td>Discount</td>
                <td style="text-align: right;">-${{ number_format($booking->discount_amount, 2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="total">
        Total Paid: ${{ number_format($booking->total_price, 2) }}
        <div class="status-badge">Payment Received via Stripe</div>
    </div>
</body>
</html>