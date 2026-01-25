<x-layout.inner :title="$service->name . ' | EcoLuxe'">
    {{-- Force Close Loader for this page --}}
    <div x-init="setTimeout(() => { $dispatch('reveal-hero') }, 100)"></div>

    {{-- Hero Section --}}
    <header class="relative pt-44 pb-24 bg-ecoluxe-ink overflow-hidden">
        {{-- Background Image from Filament --}}
        <div class="absolute inset-0 opacity-40">
            @if($service->image_path)
                <img src="{{ Storage::url($service->image_path) }}" class="w-full h-full object-cover grayscale-[30%] scale-105">
            @else
                {{-- Fallback if no image uploaded --}}
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070" class="w-full h-full object-cover grayscale-[30%]">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-ecoluxe-ink/80 via-ecoluxe-ink/40 to-white"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-8 relative z-10">
            <nav class="flex gap-2 text-ecoluxe-gold text-[10px] font-bold uppercase tracking-[0.4em] mb-8">
                <a href="/" class="hover:text-white transition-colors">Home</a> 
                <span class="text-white/20">/</span> 
                <span class="text-white/40">Services</span>
            </nav>
            
            <h1 class="font-serif text-5xl md:text-8xl text-white tracking-tighter mb-8 leading-[0.85]">
                {{ $service->name }}
            </h1>
            
            <p class="text-white/70 text-lg md:text-xl max-w-2xl leading-relaxed font-light">
                {{ $service->description }}
            </p>
        </div>
    </header>

    {{-- Main Content Section --}}
    <section class="relative z-20 -mt-10 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="grid lg:grid-cols-12 gap-16">
                
                {{-- Left: Deep details (Column 1-7) --}}
                <div class="lg:col-span-7 bg-white rounded-[3rem] p-8 md:p-16 shadow-xl shadow-ecoluxe-ink/5">
                    <div class="mb-12">
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-ecoluxe-gold mb-8">The Process & Inclusion</h2>
                        
                        {{-- This renders your Filament Rich Editor content --}}
                        <div class="prose prose-lg prose-stone max-w-none 
                            prose-headings:font-serif prose-headings:tracking-tighter
                            prose-p:text-ecoluxe-ink/70 prose-p:leading-relaxed
                            prose-li:text-ecoluxe-ink/70">
                            @if($service->content)
                                {!! $service->content !!}
                            @else
                                <p>Detailed specifications for this service are being prepared. Please contact our concierge for a full breakdown of the {{ $service->name }} standard.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-2 gap-8 py-10 border-t border-ecoluxe-ink/5 mt-12">
                        <div>
                            <h4 class="font-bold text-[10px] uppercase tracking-widest text-ecoluxe-ink/30 mb-2">Duration</h4>
                            <p class="text-ecoluxe-ink font-serif text-xl italic">Approx. 4-8 Hours</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-[10px] uppercase tracking-widest text-ecoluxe-ink/30 mb-2">Investment</h4>
                            <p class="text-ecoluxe-green font-bold text-xl">From KES {{ number_format($service->base_price) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Sticky Booking CTA (Column 8-12) --}}
                <div class="lg:col-span-5">
                    <div class="lg:sticky lg:top-32 space-y-6">
                        <div class="bg-ecoluxe-ink text-white rounded-[3rem] p-10 md:p-12 shadow-2xl relative overflow-hidden">
                            {{-- Decorative gold accent --}}
                            <div class="absolute top-0 right-0 w-32 h-32 bg-ecoluxe-gold/10 rounded-full blur-3xl"></div>
                            
                            <h3 class="font-serif text-3xl md:text-4xl mb-6 relative z-10">Secure your <span class="italic text-ecoluxe-gold">Restoration</span></h3>
                            <p class="text-white/50 mb-10 text-sm leading-relaxed relative z-10">
                                Experience the pinnacle of organic cleaning. Our specialists are ready to transform your space.
                            </p>
                            
                            <a href="/#booking" class="group block w-full bg-white text-ecoluxe-ink text-center py-6 rounded-2xl font-bold uppercase tracking-widest text-[11px] hover:bg-ecoluxe-gold transition-all duration-500 relative z-10">
                                Start Booking Request
                            </a>
                            
                            <div class="mt-8 pt-8 border-t border-white/10 flex items-center justify-between">
                                <span class="text-[9px] uppercase tracking-[0.2em] text-white/30 font-bold">Inquiries</span>
                                <a href="tel:+254..." class="text-ecoluxe-gold font-bold text-sm hover:underline">+254 EcoLuxe</a>
                            </div>
                        </div>

                        {{-- Social Proof / Trust Badge --}}
                        <div class="bg-ecoluxe-cream border border-ecoluxe-ink/5 rounded-[2rem] p-8 flex items-center gap-6">
                            <div class="flex -space-x-3">
                                <img src="https://i.pravatar.cc/100?u=1" class="w-10 h-10 rounded-full border-2 border-ecoluxe-cream">
                                <img src="https://i.pravatar.cc/100?u=2" class="w-10 h-10 rounded-full border-2 border-ecoluxe-cream">
                                <img src="https://i.pravatar.cc/100?u=3" class="w-10 h-10 rounded-full border-2 border-ecoluxe-cream">
                            </div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-ink/50">
                                400+ Homes <br><span class="text-ecoluxe-ink">Restored in Nairobi</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layout.inner>