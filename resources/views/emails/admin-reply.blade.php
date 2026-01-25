<div style="font-family: serif; color: #0c0d0d; padding: 20px;">
    <h2 style="color: #d4af37;">EcoLuxe Concierge</h2>
    <p>Dear {{ $inquiry->full_name }},</p>
    <div style="margin: 20px 0; line-height: 1.6;">
        {{-- Use $replyBody here instead of $message --}}
        
        {!! nl2br(($replyBody)) !!}
    </div>
    <hr style="border: 0; border-top: 1px solid #eee;">
    <p style="font-size: 12px; color: #666;">Original Message: <br> <i>{{ $inquiry->message }}</i></p>
</div>