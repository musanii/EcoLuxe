<p>We noticed you were interrupted while booking your <strong>{{ $booking->service->name }}</strong>.</p>

<div style="background: #fcfbf7; padding: 15px; border: 1px solid #1a4d2e10; margin: 20px 0;">
    <p style="margin: 0; font-size: 13px;">
        <strong>Reserved for:</strong> {{ $booking->scheduled_at->format('M d, Y') }}<br>
        <strong>Location:</strong> {{ $booking->city }}
    </p>
</div>

<p>Your spot is still held for the next 24 hours. Would you like to finalize your sanctuary's transformation?</p>

<a href="{{ $resumeUrl }}" 
   style="background-color: #2D4031; color: #F8F7F2; padding: 14px 25px; text-decoration: none; border-radius: 5px; font-size: 12px; font-weight: bold; display: inline-block; letter-spacing: 2px; text-transform: uppercase;">
   Resume My Booking
</a>