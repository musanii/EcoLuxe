<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F8F7F2] px-4">
        <div class="max-w-xl w-full text-center space-y-8" 
             x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            
            <div x-show="show" x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 translate-y-10"
                 class="space-y-6">
                
                <span class="text-ecoluxe-gold uppercase tracking-[0.3em] text-[10px] font-bold">Security Update</span>
                
                <h1 class="font-serif text-4xl md:text-6xl text-ecoluxe-ink leading-tight">
                    A Moment in <span class="italic font-normal">Time.</span>
                </h1>
                
                <p class="text-ecoluxe-ink/60 text-lg leading-relaxed font-light italic">
                    "Time has a way of moving forward. Your previous session has expired, but your sanctuary is still within reach."
                </p>

                <div class="pt-8">
                    <a href="{{ route('home') }}" 
                       class="inline-block bg-ecoluxe-ink text-white px-12 py-5 rounded-2xl font-bold tracking-[0.2em] text-[10px] uppercase hover:bg-ecoluxe-green transition-all duration-700 shadow-xl shadow-ecoluxe-ink/5">
                        Begin New Reservation
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>