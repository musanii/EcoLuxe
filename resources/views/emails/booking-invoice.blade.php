<div style="font-family: serif; max-width: 600px; margin: auto; padding: 40px; background-color: #F8F7F2; border: 1px solid #eee;">
    <h2 style="color: #2D4031; text-align: center;">ECOLUXE</h2>
    <p style="text-align: center; text-transform: uppercase; font-size: 10px; letter-spacing: 2px; color: #C5A059;">Official Invoice</p>
    
    <div style="margin-top: 40px; padding: 20px; background: white; border-radius: 10px;">
        <p><strong>Hello {{ $booking->customer_name }},</strong></p>
        <p>Thank you for choosing EcoLuxe. Your reservation has been logged into our system.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="font-size: 12px; color: #666;">Service</td>
                <td style="text-align: right; font-weight: bold;">{{ $booking->service->name }}</td>
            </tr>
            <tr>
                <td style="font-size: 12px; color: #666;">Schedule</td>
                <td style="text-align: right; font-weight: bold;">{{ $booking->scheduled_at->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td style="padding-top: 20px; font-size: 18px;">Total Investment</td>
                <td style="padding-top: 20px; text-align: right; font-size: 18px; font-weight: bold; color: #2D4031;">
                    ${{ number_format($booking->total_price, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <p style="font-size: 10px; color: #999; text-align: center; margin-top: 30px;">
       &copy; {{ date('Y') }} | ECOLUXE CLEANING SERVICES | PREMIUM SUSTAINABILITY VERIFIED
    </p>
</div>