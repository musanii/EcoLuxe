<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="background-color: #f6f6f6; margin: 0; padding: 20px;">
    <div style="font-family: 'Georgia', serif; max-width: 600px; margin: auto; padding: 40px; background-color: #F8F7F2; border: 1px solid #eee; border-radius: 8px;">
        
        <h2 style="color: #2D4031; text-align: center; margin-bottom: 5px; font-weight: 400; letter-spacing: 4px;">ECOLUXE</h2>
        <p style="text-align: center; text-transform: uppercase; font-size: 10px; letter-spacing: 2px; color: #C5A059; margin-top: 0;">Official Service Summary</p>
        
        <div style="margin-top: 40px; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            <p style="font-size: 16px; color: #333;"><strong>Hi {{ $booking->customer_name }},</strong></p>
            <p style="font-size: 14px; line-height: 1.6; color: #555;">Our team has just finished your cleaning service. We hope you enjoy your refreshed space!</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #2D4031; font-weight: 400;">How did we do?</h3>
                <p style="font-size: 13px; color: #666; margin-bottom: 20px;">We strive for perfection. Please take a moment to rate your experience.</p>
                
                <a href="{{ route('booking.rating', $booking->id) }}" 
                   style="background-color: #2D4031; color: #F8F7F2; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 14px; display: inline-block; letter-spacing: 1px;">
                   RATE MY EXPERIENCE
                </a>
            </div>
            
            <hr style="border: 0; border-top: 1px solid #f0f0f0; margin: 25px 0;">
            
            <table style="width: 100%; border-collapse: collapse; font-family: sans-serif;">
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding-bottom: 5px;">Service Tier</td>
                    <td style="text-align: right; font-weight: bold; color: #333;">{{ $booking->service->name }}</td>
                </tr>
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding-bottom: 5px;">Date Completed</td>
                    <td style="text-align: right; font-weight: bold; color: #333;">{{ now()->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 20px; font-size: 16px; color: #2D4031;">Total Investment</td>
                    <td style="padding-top: 20px; text-align: right; font-size: 20px; font-weight: bold; color: #2D4031;">
                        ${{ number_format($booking->total_price, 2) }}
                    </td>
                </tr>
            </table>
        </div>

        <p style="font-size: 10px; color: #999; text-align: center; margin-top: 30px; letter-spacing: 1px;">
           &copy; {{ date('Y') }} | ECOLUXE CLEANING SERVICES | PREMIUM SUSTAINABILITY VERIFIED
        </p>
    </div>
</body>
</html>


