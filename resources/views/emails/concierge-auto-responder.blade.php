<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'serif'; background-color: #fdfcf8; margin: 0; padding: 0; }
        .wrapper { width: 100%; padding: 40px 0; background-color: #fdfcf8; }
        .container { max-width: 600px; margin: 0 auto; background-color: #0c0d0d; color: #ffffff; border-radius: 40px; overflow: hidden; }
        .content { padding: 50px; text-align: center; }
        .gold-text { color: #d4af37; letter-spacing: 4px; font-size: 10px; text-transform: uppercase; font-weight: bold; }
        .header { font-size: 28px; margin: 20px 0; font-family: 'serif'; }
        .body-text { color: #e0e0e0; line-height: 1.8; font-size: 15px; margin-bottom: 30px; }
        .footer { padding: 30px; background-color: #151717; text-align: center; border-top: 1px solid #222; }
        .signature { color: #d4af37; font-style: italic; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <div class="gold-text">EcoLuxe Concierge</div>
                <h1 class="header">Your Sanctuary Awaits</h1>
                <p class="body-text">
                    Greetings {{ $name }},<br><br>
                    Thank you for reaching out to EcoLuxe. We have received your request for a personal consultation. 
                    Our lead concierge is currently reviewing your details to ensure we provide a tailored strategy for your estate.
                </p>
                <p class="body-text">
                    You can expect a personal response within the next <strong>12 hours</strong>.
                </p>
                <p class="signature">— The EcoLuxe Team</p>
            </div>
            <div class="footer">
                <p style="color: #666; font-size: 10px; letter-spacing: 2px;">NAIROBI • NAKURU • ELDORET • MOMBASA</p>
            </div>
        </div>
    </div>
</body>
</html>