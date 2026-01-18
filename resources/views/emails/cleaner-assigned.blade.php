<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="background-color: #f6f6f6; margin: 0; padding: 20px;">
    <div style="font-family: 'Georgia', serif; max-width: 600px; margin: auto; padding: 40px; background-color: #F8F7F2; border: 1px solid #eee; border-radius: 8px;">
        
        <h2 style="color: #2D4031; text-align: center; margin-bottom: 5px; font-weight: 400; letter-spacing: 4px;">ECOLUXE</h2>
        <p style="text-align: center; text-transform: uppercase; font-size: 10px; letter-spacing: 2px; color: #C5A059; margin-top: 0;">New Assignment</p>
        
        <div style="margin-top: 40px; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            <p style="font-size: 16px; color: #333;"><strong>Hello,</strong></p>
            <p style="font-size: 14px; line-height: 1.6; color: #555;">You have been assigned to a new luxury cleaning service. Here are the details for your upcoming task:</p>
            
            <hr style="border: 0; border-top: 1px solid #f0f0f0; margin: 25px 0;">
            
            <table style="width: 100%; border-collapse: collapse; font-family: sans-serif;">
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding: 10px 0;">Booking ID</td>
                    <td style="text-align: right; font-weight: bold; color: #333;">#{{ substr($booking->id, 0, 8) }}</td>
                </tr>
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding: 10px 0;">Service</td>
                    <td style="text-align: right; font-weight: bold; color: #333;">{{ $booking->service->name }}</td>
                </tr>
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding: 10px 0;">Date/Time</td>
                    <td style="text-align: right; font-weight: bold; color: #333;">{{ $booking->scheduled_at->format('M d, Y @ g:i A') }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 20px; font-size: 11px; color: #999; text-transform: uppercase;">Location</td>
                    <td style="padding-top: 20px; text-align: right; font-size: 14px; font-weight: bold; color: #2D4031; font-family: sans-serif;">
                        {{ $booking->address }}<br>
                        <span style="font-size: 12px; color: #C5A059;">{{ $booking->city }}, {{ $booking->zip_code }}</span>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 30px; padding-top: 30px; text-align: center; border-top: 1px solid #f0f0f0;">
                
                {{-- PRIMARY ACTION: DASHBOARD --}}
                <a href="{{ url('/admin/bookings/' . $booking->id) }}" 
                    style="background-color: #2D4031; color: #F8F7F2; padding: 14px 25px; text-decoration: none; border-radius: 5px; font-size: 11px; font-weight: bold; display: block; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px;">
                    View Booking Details
                </a>

                {{-- SECONDARY ACTION: NAVIGATION --}}
                @php
                    $mapQuery = urlencode($booking->address . ', ' . $booking->city . ', ' . $booking->zip_code . ', Kenya');
                    $mapUrl = "https://www.google.com/maps/search/?api=1&query={$mapQuery}";
                @endphp
                
                <a href="{{ $mapUrl }}" 
                    style="background-color: transparent; color: #2D4031; border: 1px solid #2D4031; padding: 14px 25px; text-decoration: none; border-radius: 5px; font-size: 11px; font-weight: bold; display: block; letter-spacing: 2px; text-transform: uppercase;">
                    Navigate to Site
                </a>

                <p style="font-size: 12px; color: #999; margin-top: 20px; font-style: italic;">Please confirm your arrival via the dashboard upon reaching the destination.</p>
            </div>
        </div>

        <p style="font-size: 10px; color: #999; text-align: center; margin-top: 30px; letter-spacing: 1px;">
            &copy; {{ date('Y') }} | ECOLUXE CLEANING SERVICES | PREMIUM SUSTAINABILITY VERIFIED
        </p>
    </div>
</body>
</html>