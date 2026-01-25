@php
    $testimonials = \App\Models\Booking::where('rating', '>=', 4)
    ->whereNotNull('feedback_comment')
    ->with('service') // Assuming Booking belongsTo Service
    ->latest()
    ->get();


@endphp

<section id="testimonials" class="py-20 md:py-32 bg-ecoluxe-cream overflow-hidden" 
    x-data="{ 
        active: 0,
        {{-- Merge DB data with an empty array check --}}
        testimonials: {{ $testimonials->count() > 0 ? $testimonials->map(fn($b) => [
            'text' => $b->feedback_comment,
            'author' => $b->customer_name,
            'loc' => $b->service->name ?? 'Premium Service',
            'stars' => $b->rating
        ])->toJson() : '[]' }},

        {{-- Fallback data if testimonials array is empty --}}
        get items() {
            return this.testimonials.length > 0 ? this.testimonials : [
                { 
                    text: 'The only service in Nairobi that truly understands the care required for rare mahogany and marble.', 
                    author: 'Sonia M.', 
                    loc: 'Muthaiga Estate', 
                    stars: 5 
                },
                { 
                    text: 'Our office productivity has soared since switching to their botanical-grade wellness clean.', 
                    author: 'David O.', 
                    loc: 'Westlands Corporate', 
                    stars: 5 
                }
            ];
        }
    }">

    <div class="max-w-7xl mx-auto px-4 sm:px-8">
        <div class="grid lg:grid-cols-3 gap-12 lg:gap-16 items-start">
            <div class="lg:col-span-1 text-center lg:text-left">
                <h2 class="font-serif text-4xl md:text-5xl mb-6 text-ecoluxe-ink">Voices of <br class="hidden lg:block"> The Elite</h2>
                <p class="text-ecoluxe-ink/50 mb-8 leading-relaxed">Discover why Nairobi’s most discerning households choose EcoLuxe.</p>
                
                <div class="flex justify-center lg:justify-start gap-4">
                    <button @click="active = active > 0 ? active - 1 : items.length - 1" class="p-4 rounded-full border border-ecoluxe-ink/10 hover:bg-ecoluxe-green hover:text-white transition">←</button>
                    <button @click="active = active < items.length - 1 ? active + 1 : 0" class="p-4 rounded-full border border-ecoluxe-ink/10 hover:bg-ecoluxe-green hover:text-white transition">→</button>
                </div>
            </div>

            <div class="lg:col-span-2 relative h-[450px] sm:h-[350px] md:h-[300px]">
                {{-- Changed loop to 'items' which contains either DB data or fallbacks --}}
                <template x-for="(t, index) in items" :key="index">
                    <div x-show="active === index" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-8 lg:translate-x-12"
                         x-transition:enter-end="opacity-100 translate-x-0 translate-y-0"
                         class="absolute inset-0 p-8 md:p-12 rounded-[2.5rem] bg-white shadow-xl flex flex-col justify-between border border-ecoluxe-gold/5">
                        
                        <div>
                            <div class="flex gap-1 text-ecoluxe-gold mb-4 text-xl">
                                <template x-for="i in t.stars" :key="i">
                                    <span>★</span>
                                </template>
                            </div>
                            <p class="text-lg md:text-xl font-medium leading-relaxed italic text-ecoluxe-ink" x-text="'&ldquo;' + t.text + '&rdquo;'"></p>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-ecoluxe-green/10 rounded-full flex items-center justify-center font-bold text-ecoluxe-green" x-text="t.author[0]"></div>
                            <div>
                                <p class="font-bold uppercase tracking-widest text-[9px] md:text-[10px] text-ecoluxe-ink" x-text="t.author"></p>
                                <p class="text-[9px] md:text-[10px] text-ecoluxe-gold font-semibold uppercase tracking-[0.2em]" x-text="t.loc"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>