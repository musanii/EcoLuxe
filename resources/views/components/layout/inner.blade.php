<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'EcoLuxe | Service Details' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Restoration of fonts is crucial for the "Luxe" look --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    
<style>
        #inner-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background-color: #F7F3F0; /* ecoluxe-cream */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
        }

        .loader-container {
            text-align: center;
            position: relative;
            padding: 4rem 6rem;
        }

        /* The Oval Golden Border */
        .loader-oval {
            position: absolute;
            inset: 0;
            border: 1.5px solid #D4AF37; /* ecoluxe-gold */
            border-radius: 40%;
            animation: oval-blink 2s infinite ease-in-out;
        }

        /* The Main Brand Text */
        .loader-brand {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: bold;
            color: #2D4031; /* ecoluxe-green */
            letter-spacing: -0.02em;
            position: relative;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        /* The Golden Underline */
        .loader-brand::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 10%;
            width: 80%;
            height: 2px;
            background: #D4AF37; /* ecoluxe-gold */
        }

        /* The Subtext */
        .loader-subtext {
            display: block;
            font-family: 'Instrument Sans', sans-serif;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5em;
            color: #D4AF37; /* ecoluxe-gold */
            margin-top: 1rem;
        }

        /* Animations */
        @keyframes oval-blink {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }

        /* Transition to hide */
        .loaded #inner-loader {
            opacity: 0;
            visibility: hidden;
        }

        /* Scroll Logic */
        body { overflow: hidden; }
        body.loaded { overflow-y: auto !important; height: auto !important; }
    </style>
</head>
{{-- Added x-data here so the Nav logic actually works --}}
<body x-data="{ mobileMenuOpen: false }"
 class="bg-ecoluxe-cream text-ecoluxe-ink antialiased font-sans overfloy-y-auto">
<div id="inner-loader">
        <div class="loader-container">
            <div class="loader-oval"></div>
            <h2 class="loader-brand">ECOLUXE</h2>
            <span class="loader-subtext">Restoring Sanctuaries</span>
        </div>
    </div>
    
    <nav class="sticky top-0 w-full z-[100] bg-ecoluxe-cream/95 backdrop-blur-xl border-b border-ecoluxe-ink/5 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between">
            <a href="/" class="text-2xl md:text-3xl font-serif font-bold tracking-tighter text-ecoluxe-green">ECOLUXE</a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-10 text-[11px] font-bold uppercase tracking-[0.2em]">
                <a href="/#services" class="text-ecoluxe-ink/60 hover:text-ecoluxe-green transition-colors">Services</a>
                <a href="/#booking" class="text-ecoluxe-ink/60 hover:text-ecoluxe-green transition-colors">The Concierge</a>
                <a href="/#testimonials" class="text-ecoluxe-ink/60 hover:text-ecoluxe-green transition-colors">Kind Words</a>
                <a href="/#contact" class="text-ecoluxe-ink/60 hover:text-ecoluxe-green transition-colors">Inquiries</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="/#booking" class="bg-ecoluxe-green text-white px-6 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-ecoluxe-ink transition-all shadow-lg shadow-ecoluxe-green/20">Reserve</a>
                
                {{-- Mobile Menu Toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-ecoluxe-ink">
                    <div class="w-6 space-y-1.5">
                        <span :class="mobileMenuOpen ? 'rotate-45 translate-y-2' : ''" class="block h-0.5 w-full bg-current transition-transform"></span>
                        <span :class="mobileMenuOpen ? '-rotate-45 -translate-y-2' : ''" class="block h-0.5 w-full bg-current transition-transform"></span>
                    </div>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Overlay --}}
        <div x-show="mobileMenuOpen" x-cloak 
             class="fixed inset-0 h-screen w-full bg-ecoluxe-cream z-[110] flex flex-col items-center justify-center lg:hidden">
             <button @click="mobileMenuOpen = false" class="absolute top-8 right-8 text-2xl">✕</button>
             <div class="flex flex-col gap-8 text-center text-3xl font-serif">
                <a href="/#services" @click="mobileMenuOpen = false">Services</a>
                <a href="/#booking" @click="mobileMenuOpen = false">The Concierge</a>
                <a href="/#testimonials" @click="mobileMenuOpen = false;document.body.style.overflow = 'auto'" class="text-4xl font-serif">Kind Words</a>
                <a href="/#contact" @click="mobileMenuOpen = false">Inquiries</a>
             </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>
    <script>
        // Use a simple, non-Alpine listener to unlock the page
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.body.classList.add('loaded');
            }, 100); // Short delay for a smooth feel
        });
    </script>

     <footer class="bg-ecoluxe-ink text-white pt-20 md:pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-20 mb-20 lg:mb-32 text-center sm:text-left">
                <div class="sm:col-span-2 space-y-8">
                    <h2 class="text-4xl md:text-5xl font-serif font-bold tracking-tighter italic text-ecoluxe-green">ECOLUXE</h2>
                    <p class="text-white/40 max-w-sm mx-auto sm:mx-0 text-base md:text-lg font-medium leading-relaxed">
                        Redefining the standard of living through conscious, botanical-first restoration.
                    </p>
                </div>
                <div class="space-y-6 md:space-y-8">
                    <h4 class="text-ecoluxe-gold uppercase tracking-[0.2em] text-[10px] font-bold">Navigation</h4>
                    <ul class="space-y-4 text-white/60 text-sm font-medium uppercase tracking-widest text-[11px]">
                        <li><a href="/#services" class="hover:text-white transition">Services</a></li>
                        <li><a href="/#booking" class="hover:text-white transition">The Concierge</a></li>
                        <li><a href="/#journal" class="hover:text-white transition">Journal</a></li>
                    </ul>
                </div>
                <div class="space-y-6 md:space-y-8">
                    <h4 class="text-ecoluxe-gold uppercase tracking-[0.2em] text-[10px] font-bold">Newsletter</h4>
                    <p class="text-[10px] text-white/40 uppercase tracking-widest leading-relaxed">The weekly edit on sustainable luxury.</p>
                    @livewire('newsletter-subscribe')
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between pt-12 border-t border-white/5 text-[9px] md:text-[10px] uppercase tracking-[0.2em] text-white/20 text-center md:text-left gap-6">
                <p>&copy; {{ date('Y') }} | ECOLUXE CLEANING SERVICES | PREMIUM SUSTAINABILITY VERIFIED</p>
                <div class="flex justify-center md:justify-start gap-8 md:gap-10 font-bold">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>