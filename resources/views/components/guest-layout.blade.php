<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EcoLuxe Cleaning') }} | Premium Sustainability</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-serif-lux { font-family: 'Playfair Display', serif; }
            .font-sans-lux { font-family: 'Inter', sans-serif; }
            .bg-ecoluxe-cream { background-color: #F8F7F2; }
            .text-ecoluxe-green { color: #2D4031; }
            .border-ecoluxe-gold { border-color: #C5A059; }
        </style>
    </head>
    <body class="font-sans-lux antialiased bg-ecoluxe-cream text-gray-800">
        <div class="min-h-screen flex flex-col items-center py-12 px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 text-center">
                <a href="/" class="flex flex-col items-center group">
               
                    <h1 class="font-serif-lux text-3xl tracking-[0.2em] text-ecoluxe-green uppercase">EcoLuxe</h1>
                    <div class="h-[1px] w-24 bg-[#C5A059] mt-2"></div>
                    <p class="text-[10px] tracking-[0.3em] uppercase mt-2 text-[#C5A059] font-semibold">Premium Sustainability</p>
                </a>
            </div>

            <div class="w-full max-w-lg">
                <div class="bg-white p-8 sm:p-12 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] rounded-2xl border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-[#2D4031]"></div>
                    
                    <main>
                           @if (session()->has('message'))
                            <div id="flash-message" class="mb-6 p-4 rounded-md bg-[#F8F7F2] border border-[#C5A059] flex items-center justify-between transition-opacity duration-500">
                            <div class="flex items-center">
                            <svg class="h-5 w-5 text-[#C5A059]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="ml-3 text-sm font-medium text-[#2D4031] font-sans-lux">
                            {{ session('message') }}
                            </p>
                            </div>
                            <button onclick="document.getElementById('flash-message').style.display='none'" class="text-[#C5A059] hover:text-[#2D4031]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            </div>
                            @endif
                                    @if ($errors->any())
                                <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <ul class="list-disc list-inside text-sm text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        {{ $slot }}
                    </main>
                </div>

                <footer class="mt-12 text-center">
                    <p class="text-[11px] uppercase tracking-widest text-gray-400">
                       &copy; {{ date('Y') }} | ECOLUXE CLEANING SERVICES | PREMIUM SUSTAINABILITY VERIFIED
                    </p>
                </footer>
            </div>
        </div>
    </body>
</html>