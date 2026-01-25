<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'EcoLuxe | Premium Sustainable Cleaning' }}</title>
    <style>[x-cloak] { display: none !important; } html { scroll-padding-top: 100px; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
    [x-cloak] { display: none !important; }
    /* The loader will be visible by default and hidden via JS */
    #global-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: #F7F3F0; /* ecoluxe-cream */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }
    body.loaded #global-loader {
        opacity: 0;
        visibility: hidden;
    }
    body.loading { overflow: hidden; }
</style>
</head>
<body
x-data="{ 
    mobileMenuOpen: false,
    showBackToTop: false 
}" 
@scroll.window="showBackToTop = (window.pageYOffset > 500)"
class="antialiased bg-ecoluxe-cream text-ecoluxe-ink font-sans overflow-x-hidden">

   <div class="fixed top-0 left-0 h-0.5 bg-ecoluxe-gold z-[150] transition-all duration-300 shadow-[0_0_10px_rgba(212,175,55,0.5)]" 
     :style="'width: ' + (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight) * 100) + '%'"></div>

    <nav x-data="{ 
        activeSection: '',
        init() {
            // Force body to be scrollable on load
            document.body.style.overflow = 'auto';
            document.documentElement.style.overflow = 'auto';

            const sections = ['services', 'booking', 'testimonials', 'contact'];
            window.addEventListener('scroll', () => {
                let current = '';
                const scrollPos = window.pageYOffset + 150;

                // Footer / Bottom detection
                if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 60) {
                    current = 'contact';
                } else {
                    sections.forEach(id => {
                        const el = document.getElementById(id);
                        if (el && scrollPos >= el.offsetTop) current = id;
                    });
                }
                this.activeSection = current;
            });
        }
    }" 
    class="fixed top-0 w-full z-[100] bg-ecoluxe-cream/95 backdrop-blur-xl border-b border-ecoluxe-ink/5 py-4">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between">
            <a href="/" class="text-2xl md:text-3xl font-serif font-bold tracking-tighter text-ecoluxe-green z-[120]">ECOLUXE</a>

            <div class="hidden lg:flex items-center gap-10 text-[11px] font-bold uppercase tracking-[0.2em]">
                <template x-for="link in [['Services', 'services'], ['The Standard', 'booking'], ['Kind Words', 'testimonials'], ['Inquiries', 'contact']]">
                    <a :href="'#' + link[1]" 
                       :class="activeSection === link[1] ? 'text-ecoluxe-green' : 'text-ecoluxe-ink/60'"
                       class="hover:text-ecoluxe-green transition-colors" x-text="link[0]"></a>
                </template>
            </div>

            <div class="flex items-center gap-4 z-[120]">
                <a href="#booking" class="bg-ecoluxe-green text-white px-6 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-ecoluxe-ink transition-all shadow-lg shadow-ecoluxe-green/20">Reserve</a>
                
                <button @click="mobileMenuOpen = !mobileMenuOpen; document.body.style.overflow = mobileMenuOpen ? 'hidden' : 'auto'" class="lg:hidden p-2 text-ecoluxe-ink">
                    <div class="w-6 space-y-1.5">
                        <span :class="mobileMenuOpen ? 'rotate-45 translate-y-2' : ''" class="block h-0.5 w-full bg-current transition-transform"></span>
                        <span :class="mobileMenuOpen ? 'opacity-0' : ''" class="block h-0.5 w-full bg-current transition-opacity"></span>
                        <span :class="mobileMenuOpen ? '-rotate-45 -translate-y-2' : ''" class="block h-0.5 w-full bg-current transition-transform"></span>
                    </div>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
             class="fixed inset-0 h-screen w-full bg-ecoluxe-cream z-[110] lg:hidden flex flex-col items-center justify-center">
            <div class="flex flex-col gap-8 text-center">
                <a href="#services" @click="mobileMenuOpen = false; document.body.style.overflow = 'auto'" class="text-4xl font-serif">Services</a>
                <a href="#booking" @click="mobileMenuOpen = false; document.body.style.overflow = 'auto'" class="text-4xl font-serif">The Standard</a>
                <a href="#contact" @click="mobileMenuOpen = false; document.body.style.overflow = 'auto'" class="text-4xl font-serif">Inquiries</a>
            </div>
        </div>
    </nav>

  

    {{-- Fixed Loading Spinner --}}
<div x-data="{ loading: true }" 
     x-init="
     document.body.style.overflow = 'hidden';
     $nextTick(() => { 
        setTimeout(() => { 
            loading = false; 
            $dispatch('reveal-hero'); 
        }, 600); 
     })" 
     x-show="loading" 
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[200] bg-ecoluxe-cream flex flex-col items-center justify-center">
    <h2 class="text-3xl font-serif font-bold text-ecoluxe-green animate-pulse tracking-tighter">ECOLUXE</h2>
</div>

    {{-- Main Content Slot --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
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
                        <li><a href="#services" class="hover:text-white transition">Services</a></li>
                        <li><a href="#booking" class="hover:text-white transition">The Concierge</a></li>
                        <li><a href="#journal" class="hover:text-white transition">Journal</a></li>
                    </ul>
                </div>
                <div class="space-y-6 md:space-y-8">
                    <h4 class="text-ecoluxe-gold uppercase tracking-[0.2em] text-[10px] font-bold">Newsletter</h4>
                    <p class="text-[10px] text-white/40 uppercase tracking-widest leading-relaxed">The weekly edit on sustainable luxury.</p>
                    <input type="text" placeholder="Email address" class="w-full bg-transparent border-b border-white/10 py-4 focus:outline-none focus:border-ecoluxe-gold transition text-sm">
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

    <button x-show="showBackToTop" @click="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-8 right-8 z-[90] p-4 bg-ecoluxe-green text-white rounded-full">↑</button>
<script>
        // Fail-safe: If Alpine fails to initialize, force hide the loader
        setTimeout(() => {
            const loader = document.querySelector('[x-show="isLoading"]');
            if (loader && window.getComputedStyle(loader).display !== 'none') {
                console.warn('Alpine.js failed to hide loader. Forcing hide.');
                loader.style.display = 'none';
                document.body.style.overflow = 'auto';
                document.body.classList.remove('loading');
            }
        }, 1500);
    </script>
</body>
</html>