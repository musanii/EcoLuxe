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
        <div class="fixed top-32 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4 pointer-events-none">
    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white border-l-4 border-ecoluxe-green shadow-xl p-4 flex items-center justify-between pointer-events-auto">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-ecoluxe-green mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-serif text-ecoluxe-ink">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-ecoluxe-ink/30 hover:text-ecoluxe-ink">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session()->has('error') || $errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
             x-transition:enter="transition ease-out duration-300"
             class="bg-white border-l-4 border-red-800 shadow-xl p-4 flex items-center justify-between pointer-events-auto">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-800 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-serif text-ecoluxe-ink">
                    {{ session('error') ?: 'There was an issue with your request.' }}
                </p>
            </div>
            <button @click="show = false" class="text-ecoluxe-ink/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
</div>
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>