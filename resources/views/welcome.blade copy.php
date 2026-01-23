<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoLuxe | Premium Sustainable Cleaning</title>
    <style>
    [x-cloak] { display: none !important; }
    html { scroll-padding-top: 100px; } /* Adjust this to match your nav height */
</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    
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

    <button x-show="showBackToTop" 
            x-transition @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-8 right-8 z-[90] p-4 bg-ecoluxe-green text-white rounded-full shadow-2xl hover:bg-ecoluxe-ink transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
    </button>
   <header class="relative min-h-screen flex items-center pt-28 md:pt-32 pb-12 overflow-hidden"
        x-data="{ show: false }"
        @reveal-hero.window="show = true">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-8 w-full grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        
        <div class="space-y-8 md:space-y-10 text-center lg:text-left order-2 lg:order-1">
            
            <h1 class="font-serif text-5xl sm:text-7xl md:text-8xl lg:text-[110px] leading-[0.9] tracking-tighter"
                x-show="show"
                x-transition:enter="transition ease-out duration-1000 delay-100"
                x-transition:enter-start="opacity-0 translate-y-12"
                x-transition:enter-end="opacity-100 translate-y-0">
                Pure <span class="italic font-normal text-ecoluxe-green">Home.</span><br>
                Pure <span class="text-ecoluxe-gold">Soul.</span>
            </h1>

            <p class="text-lg md:text-xl text-ecoluxe-ink/50 max-w-lg mx-auto lg:mx-0 leading-relaxed"
               x-show="show"
               x-transition:enter="transition ease-out duration-1000 delay-300"
               x-transition:enter-start="opacity-0 translate-y-8"
               x-transition:enter-end="opacity-100 translate-y-0">
                Bespoke organic cleaning for the world's most discerning homes. Experience a clinical deep clean with the scent of a botanical garden.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 pt-4"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-1000 delay-500"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <a href="#booking" class="w-full sm:w-auto bg-ecoluxe-ink text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-ecoluxe-green transition-colors text-center shadow-2xl shadow-ecoluxe-ink/10">Get Instant Quote</a>
                <div class="hidden sm:block h-12 w-px bg-ecoluxe-ink/10"></div>
                <p class="text-[10px] font-bold text-ecoluxe-gold uppercase tracking-[0.3em]">Nairobi • Nakuru • Eldoret</p>
            </div>
        </div>
        
        <div class="relative group order-1 lg:order-2 px-4 sm:px-0"
             x-show="show"
             x-transition:enter="transition ease-out duration-1000 delay-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="absolute -inset-4 bg-ecoluxe-gold/10 rounded-[3rem] md:rounded-[4rem] blur-2xl group-hover:bg-ecoluxe-green/10 transition duration-1000"></div>
            <img src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&q=80&w=1200" 
                 class="relative rounded-[2.5rem] md:rounded-[3rem] shadow-3xl grayscale-[20%] group-hover:grayscale-0 transition duration-700 w-full object-cover aspect-[4/5] md:aspect-auto" alt="Luxe Interior">
        </div>

    </div>
</header>

    <section id="services" class="py-20 md:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 md:mb-20 gap-8">
                <div class="max-w-2xl text-center lg:text-left">
                    <h2 class="font-serif text-4xl md:text-6xl mb-6 tracking-tighter text-ecoluxe-ink leading-tight">The <span class="italic text-ecoluxe-green">Standard</span> of Excellence</h2>
                    <p class="text-base md:text-lg text-ecoluxe-ink/50 leading-relaxed">
                        Surgical precision, botanical chemistry, and a white-glove finish. Consistent excellence for every restoration.
                    </p>
                </div>
                <div class="hidden lg:flex items-center gap-4 border-b border-ecoluxe-gold/30 pb-3 min-w-[180px] justify-end group">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-ecoluxe-gold">Scroll to explore</span>
                    <svg class="w-4 h-4 animate-bounce text-ecoluxe-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <div class="group relative overflow-hidden rounded-[2.5rem] bg-ecoluxe-cream p-8 md:p-12 transition-all duration-700 hover:-translate-y-2">
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:bg-ecoluxe-green group-hover:text-white transition-colors duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-serif font-bold mb-3">EcoLuxe Essential</h3>
                        <p class="text-ecoluxe-ink/50 mb-6 md:mb-8 leading-relaxed text-sm">Focuses on high-touch surfaces and botanical sanitization for weekly care.</p>
                        <ul class="space-y-3 text-[10px] font-bold uppercase tracking-widest text-ecoluxe-ink/70">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-ecoluxe-gold"></span> HEPA Dust Extraction</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-ecoluxe-gold"></span> Organic Finish</li>
                        </ul>
                    </div>
                    <div class="absolute -bottom-6 -right-6 text-8xl md:text-[10rem] font-serif italic text-ecoluxe-green/5 group-hover:text-ecoluxe-green/10 transition-colors">01</div>
                </div>

                <div class="group relative overflow-hidden rounded-[2.5rem] bg-ecoluxe-ink p-8 md:p-12 text-white transition-all duration-700 hover:-translate-y-2 shadow-2xl md:scale-105 z-10">
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-md group-hover:bg-ecoluxe-gold group-hover:text-ecoluxe-ink transition-colors duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path></svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-serif font-bold mb-3">The Deep Polish</h3>
                        <p class="text-white/50 mb-6 md:mb-8 leading-relaxed text-sm">A microscopic-level purge. We address hidden areas and upholstery extraction.</p>
                        <ul class="space-y-3 text-[10px] font-bold uppercase tracking-widest text-white/70">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-ecoluxe-gold"></span> Steam Sanitized</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-ecoluxe-gold"></span> Cabinet Detail</li>
                        </ul>
                    </div>
                    <div class="absolute -bottom-6 -right-6 text-8xl md:text-[10rem] font-serif italic text-white/5 group-hover:text-ecoluxe-gold/10 transition-colors">02</div>
                </div>

                <div class="group relative overflow-hidden rounded-[2.5rem] bg-ecoluxe-cream p-8 md:p-12 transition-all duration-700 hover:-translate-y-2">
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:bg-ecoluxe-green group-hover:text-white transition-colors duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-serif font-bold mb-3">The Fresh Start</h3>
                        <p class="text-ecoluxe-ink/50 mb-6 md:mb-8 leading-relaxed text-sm">Designed for property transitions. A complete baseline restoration.</p>
                        <ul class="space-y-3 text-[10px] font-bold uppercase tracking-widest text-ecoluxe-ink/70">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-ecoluxe-gold"></span> Move-in Ready</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-ecoluxe-gold"></span> Window Polish</li>
                        </ul>
                    </div>
                    <div class="absolute -bottom-6 -right-6 text-8xl md:text-[10rem] font-serif italic text-ecoluxe-green/5 group-hover:text-ecoluxe-green/10 transition-colors">03</div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="py-20 md:py-32 bg-white px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="font-serif text-4xl md:text-5xl mb-4 text-ecoluxe-ink">The Concierge</h2>
                <p class="text-ecoluxe-ink/40 font-medium italic text-base md:text-lg tracking-wide">Calculated precision for your sanctuary.</p>
            </div>
            <div class="ring-1 ring-ecoluxe-ink/5 rounded-[2.5rem] md:rounded-[3.5rem] p-1 shadow-2xl overflow-hidden bg-ecoluxe-cream">
                <div class="bg-white rounded-[2.3rem] md:rounded-[3.3rem] p-5 md:p-12 lg:p-16">
                    <livewire:booking-calculator />
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-20 md:py-32 bg-ecoluxe-cream overflow-hidden" x-data="{ 
        active: 0,
        testimonials: [
            { text: 'The only service that understands the delicacy of Carrera marble and the importance of air quality.', author: 'Lady Catherine S.', loc: 'Mayfair, London' },
            { text: 'EcoLuxe has transformed our townhouse. The botanical scent they leave behind is signature.', author: 'James Arrington', loc: 'Upper East Side, NYC' },
            { text: 'Professionalism at its peak. Their attention to detail in the library was impressive.', author: 'Marcus V.', loc: 'Jumeirah, Dubai' }
        ]
    }">

    <!--spinner-->

   <div x-data="{ loading: true }" 
     x-init="window.onload = () => { 
        setTimeout(() => { 
            loading = false;
            $dispatch('reveal-hero'); // Notifies the hero to animate
        }, 800) 
     }" 
     x-show="loading"
     x-transition:leave="transition ease-in duration-700"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[200] bg-ecoluxe-cream flex flex-col items-center justify-center">
    
    <div class="relative">
        <div class="absolute inset-0 rounded-full border border-ecoluxe-green/20 animate-ping"></div>
        
        <div class="relative flex flex-col items-center gap-6">
            <h2 class="text-3xl font-serif font-bold tracking-tighter text-ecoluxe-green animate-pulse">
                ECOLUXE
            </h2>
            
            <div class="flex flex-col items-center gap-2">
                <div class="w-48 h-[1px] bg-ecoluxe-ink/5 overflow-hidden">
                    <div class="h-full bg-ecoluxe-gold transition-all duration-1000 ease-out"
                         :style="loading ? 'width: 100%' : 'width: 0%'"></div>
                </div>
                <span class="text-[9px] font-bold uppercase tracking-[0.4em] text-ecoluxe-gold animate-pulse">
                    Restoring Sanctuary
                </span>
            </div>
        </div>
    </div>
</div>
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid lg:grid-cols-3 gap-12 lg:gap-16 items-start">
                <div class="lg:col-span-1 text-center lg:text-left">
                    <h2 class="font-serif text-4xl md:text-5xl mb-6 text-ecoluxe-ink">Voices of <br class="hidden lg:block"> The Elite</h2>
                    <p class="text-ecoluxe-ink/50 mb-8 leading-relaxed">Discover why 500+ premium households trust EcoLuxe.</p>
                    <div class="flex justify-center lg:justify-start gap-4">
                        <button @click="active = active > 0 ? active - 1 : testimonials.length - 1" class="p-4 rounded-full border border-ecoluxe-ink/10 hover:bg-ecoluxe-green hover:text-white transition">←</button>
                        <button @click="active = active < testimonials.length - 1 ? active + 1 : 0" class="p-4 rounded-full border border-ecoluxe-ink/10 hover:bg-ecoluxe-green hover:text-white transition">→</button>
                    </div>
                </div>
                <div class="lg:col-span-2 relative h-[400px] sm:h-[350px] md:h-[300px]">
                    <template x-for="(t, index) in testimonials" :key="index">
                        <div x-show="active === index" 
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-y-8 lg:translate-x-12 lg:translate-y-0"
                             x-transition:enter-end="opacity-100 translate-x-0 translate-y-0"
                             class="absolute inset-0 p-8 md:p-12 rounded-[2.5rem] bg-white shadow-xl flex flex-col justify-between">
                            <div>
                                <div class="text-ecoluxe-gold mb-4 text-xl md:text-2xl">★★★★★</div>
                                <p class="text-lg md:text-xl font-medium leading-relaxed italic" x-text="'&ldquo;' + t.text + '&rdquo;'"></p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-ecoluxe-green/10 rounded-full flex items-center justify-center font-bold text-ecoluxe-green" x-text="t.author[0]"></div>
                                <div>
                                    <p class="font-bold uppercase tracking-widest text-[9px] md:text-[10px]" x-text="t.author"></p>
                                    <p class="text-[9px] md:text-[10px] text-ecoluxe-ink/40 uppercase tracking-widest" x-text="t.loc"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

   <section id="contact" class="py-20 md:py-32 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid lg:grid-cols-2 gap-16 lg:gap-24">
                <div class="text-center lg:text-left">
                    <h2 class="font-serif text-4xl md:text-5xl mb-6 text-ecoluxe-ink leading-tight">Personal <br class="hidden lg:block"> Consultation</h2>
                    <p class="text-base md:text-lg text-ecoluxe-ink/60 mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0">For estates exceeding 5,000 sq ft or commercial inquiries, our lead concierge will handle your request personally.</p>
                    <div class="space-y-4 inline-block lg:block text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-ecoluxe-cream flex items-center justify-center text-ecoluxe-green italic font-serif">e</div>
                            <span class="font-bold tracking-[0.2em] text-[10px] uppercase text-ecoluxe-ink/70">concierge@ecoluxe.co.ke</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-ecoluxe-cream flex items-center justify-center text-ecoluxe-green italic font-serif text-sm">p</div>
                            <span class="font-bold tracking-[0.2em] text-[10px] uppercase text-ecoluxe-ink/70">+254 (721) 729078</span>
                        </div>
                    </div>
                </div>
                <form class="space-y-4 md:space-y-6 bg-ecoluxe-cream/20 p-6 md:p-10 rounded-[2.5rem] border border-ecoluxe-ink/5">
                    <div class="grid md:grid-cols-2 gap-4 md:gap-6">
                        <input type="text" placeholder="Full Name" class="w-full p-4 md:p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all text-sm">
                        <input type="email" placeholder="Email Address" class="w-full p-4 md:p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all text-sm">
                    </div>
                    <textarea placeholder="Tell us about your home..." rows="4" class="w-full p-4 md:p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all text-sm"></textarea>
                    <button class="bg-ecoluxe-ink text-white px-10 py-5 rounded-2xl font-bold hover:bg-ecoluxe-green transition-all shadow-xl shadow-ecoluxe-ink/10 w-full lg:w-auto text-sm md:text-base">Send Inquiry</button>
                </form>
            </div>
        </div>
    </section>

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

</body>
</html>