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