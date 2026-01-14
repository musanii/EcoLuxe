<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoLuxe | Premium Service</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        .bg-ecoluxe-cream { background-color: #F8F7F2; }
        .text-ecoluxe-ink { color: #1A1A1A; }
        .bg-ecoluxe-green { background-color: #2D4031; }
        .text-ecoluxe-gold { color: #C5A059; }
    </style>
</head>
<body class="antialiased">
    
    <main>
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>