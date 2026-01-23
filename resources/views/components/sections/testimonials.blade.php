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