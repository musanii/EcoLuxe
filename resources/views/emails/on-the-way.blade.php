<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="background-color: #f6f6f6; margin: 0; padding: 20px;">
    <div style="font-family: 'Georgia', serif; max-width: 600px; margin: auto; padding: 40px; background-color: #F8F7F2; border: 1px solid #eee; border-radius: 8px;">
        
        <h2 style="color: #2D4031; text-align: center; margin-bottom: 5px; font-weight: 400; letter-spacing: 4px;">ECOLUXE</h2>
        <p style="text-align: center; text-transform: uppercase; font-size: 10px; letter-spacing: 2px; color: #C5A059; margin-top: 0;">Arrival Update</p>
        
        <div style="margin-top: 40px; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            <p style="font-size: 16px; color: #333;"><strong>Hi {{ $booking->customer_name }},</strong></p>
            <p style="font-size: 14px; line-height: 1.6; color: #555;">Great news! Your EcoLuxe professional is officially **on the way** to your location.</p>
            
            <div style="background-color: #F8F7F2; border-left: 4px solid #2D4031; padding: 20px; margin: 25px 0;">
                <p style="margin: 0; font-size: 15px; color: #2D4031;">
                    <strong>Estimated Arrival:</strong> 15-30 Minutes
                </p>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-family: sans-serif; margin-bottom: 20px;">
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">Service</td>
                    <td style="text-align: right; font-weight: bold; color: #333; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">{{ $booking->service->name }}</td>
                </tr>
                <tr>
                    <td style="font-size: 11px; color: #999; text-transform: uppercase; padding: 8px 0;">Address</td>
                    <td style="text-align: right; font-weight: bold; color: #333; padding: 8px 0;">{{ $booking->customer_address ?? 'Your saved location' }}</td>
                </tr>
            </table>

            <p style="font-size: 12px; color: #888; font-style: italic; text-align: center; margin-top: 20px;">
                Please ensure our team has access to the property upon arrival to begin your transformation.
            </p>
        </div>

        <p style="font-size: 10px; color: #999; text-align: center; margin-top: 30px; letter-spacing: 1px;">
            &copy; {{ date('Y') }} | ECOLUXE CLEANING SERVICES | PREMIUM SUSTAINABILITY VERIFIED
        </p>
    </div>
</body>
</html>