<section id="services" class="py-20 md:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 md:mb-20 gap-8">
            <div class="max-w-2xl text-center lg:text-left">
                <h2 class="font-serif text-4xl md:text-6xl mb-6 tracking-tighter text-ecoluxe-ink leading-tight">
                    The <span class="italic text-ecoluxe-green">Standard</span> of Excellence
                </h2>
                <p class="text-base md:text-lg text-ecoluxe-ink/50 leading-relaxed">
                    Surgical precision, botanical chemistry, and a white-glove finish. Consistent excellence for every restoration.
                </p>
            </div>
            
            <div class="hidden lg:flex items-center gap-4 border-b border-ecoluxe-gold/30 pb-3 min-w-[180px] justify-end group">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-ecoluxe-gold">Scroll to explore</span>
                <svg class="w-4 h-4 animate-bounce text-ecoluxe-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>

        {{-- Dynamic Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @foreach(\App\Models\Service::all() as $index => $service)
                @php
                    $isFeatured = $service->is_featured; 
                    // Fallback images if your database doesn't have an image_url column yet
                   $images = [
                                'https://images.unsplash.com/photo-1581578731548-c64695cc6954?q=80&w=2070', // Modern Kitchen
                                'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?q=80&w=1974', // Housekeeping Detail
                                'https://images.unsplash.com/photo-1603633056153-066967733077?q=80&w=2070', // Luxury Bathroom
                                'https://images.unsplash.com/photo-1613545325278-f24b0cae1224?q=80&w=2070', // Minimalist Living Room
                                'https://images.unsplash.com/photo-1556911220-e150243e3096?q=80&w=2070', // Bright Interior
                                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070', // Estate Exterior/Hallway
                            ];

   
    $bgImage = $service->image_path ?? $images[$index % count($images)];
                @endphp

                <a href="{{ route('services.show', $service->id) }}" class="group relative overflow-hidden rounded-[2.5rem] p-8 md:p-12 min-h-[450px] transition-all duration-700 hover:-translate-y-2 flex flex-col justify-end 
                    {{ $isFeatured ? 'bg-ecoluxe-ink text-white shadow-2xl md:scale-105 z-10' : 'bg-ecoluxe-cream text-ecoluxe-ink' }}">
                    
                    {{-- 1. THE BACKGROUND IMAGE LAYER --}}
                    <div class="absolute inset-0 z-0">
                        <img src="{{ Storage::url($service->image_path) }}" 
                            class="w-full h-full object-cover transition duration-1000 opacity-20 blur-[2px] group-hover:blur-0 group-hover:scale-110 group-hover:opacity-30 grayscale group-hover:grayscale-0" 
                            alt="{{ $service->name }}">
                        {{-- Dark overlay for featured card, Light for others --}}
                        <div class="absolute inset-0 {{ $isFeatured ? 'bg-gradient-to-t from-ecoluxe-ink via-ecoluxe-ink/80' : 'bg-gradient-to-t from-ecoluxe-cream via-ecoluxe-cream/60' }}"></div>
                    </div>

                    {{-- 2. CONTENT LAYER (Above image) --}}
                    <div class="relative z-10">
                        {{-- Icon Container --}}
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-sm transition-colors duration-500
                            {{ $isFeatured ? 'bg-white/10 backdrop-blur-md group-hover:bg-ecoluxe-gold group-hover:text-ecoluxe-ink' : 'bg-white group-hover:bg-ecoluxe-green group-hover:text-white' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service->icon }}"></path>
                            </svg>
                        </div>

                        <h3 class="text-xl md:text-2xl font-serif font-bold mb-3 tracking-tight">{{ $service->name }}</h3>
                        <p class="mb-6 leading-relaxed text-sm {{ $isFeatured ? 'text-white/60' : 'text-ecoluxe-ink/60' }}">
                            {{ $service->description }}
                        </p>

                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] {{ $isFeatured ? 'text-ecoluxe-gold' : 'text-ecoluxe-green' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span> 
                            From KES {{ number_format($service->base_price) }}
                        </div>
                    </div>

                    {{-- 3. BACKGROUND NUMBER LAYER --}}
                    <div class="absolute top-4 right-4 text-6xl md:text-8xl font-serif italic pointer-events-none transition-opacity duration-500 opacity-20 group-hover:opacity-40
                        {{ $isFeatured ? 'text-white' : 'text-ecoluxe-green' }}">
                        0{{ $index + 1 }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>