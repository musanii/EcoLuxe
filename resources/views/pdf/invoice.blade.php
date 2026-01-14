<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; color: #1a1a1a; }
        .header { text-align: center; margin-bottom: 50px; }
        .logo { font-size: 24px; font-weight: bold; color: #2D4031; letter-spacing: 5px; }
        .invoice-title { color: #C5A059; text-transform: uppercase; font-size: 12px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th { text-align: left; font-size: 10px; color: #999; text-transform: uppercase; padding-bottom: 10px; }
        td { padding: 15px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .total-row td { border-bottom: none; font-weight: bold; font-size: 18px; padding-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">ECOLUXE</div>
        <div class="invoice-title">Official Service Invoice</div>
    </div>

    <p><strong>To:</strong> {{ $booking->customer_name }}<br>
    <strong>Email:</strong> {{ $booking->customer_email }}<br>
    <strong>Date:</strong> {{ $booking->created_at->format('M d, Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Service Details</th>
                <th style="text-align: right;">Investment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $booking->service->name }}</strong><br>
                    <small>{{ $booking->total_rooms }} Rooms - Scheduled for {{ $booking->scheduled_at->format('M d, Y') }}</small>
                </td>
                <td style="text-align: right;">${{ number_format($booking->subtotal, 2) }}</td>
            </tr>
            @if($booking->discount_amount > 0)
            <tr>
                <td style="color: #2D4031;">Frequency Appreciation</td>
                <td style="text-align: right; color: #2D4031;">-${{ number_format($booking->discount_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Total Investment</td>
                <td style="text-align: right;">${{ number_format($booking->total_price, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>