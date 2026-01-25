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
       <form wire:submit.prevent="sendInquiry" class="space-y-4 md:space-y-6 bg-ecoluxe-cream/20 p-6 md:p-10 rounded-[2.5rem] border border-ecoluxe-ink/5">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-ecoluxe-green bg-white rounded-2xl font-bold italic shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-4 md:gap-6">
        {{-- Full Name Field --}}
        <div>
            <input wire:model="full_name" type="text" placeholder="Full Name" 
                class="w-full p-4 md:p-5 bg-white rounded-2xl border-none ring-1 {{ $errors->has('full_name') ? 'ring-red-400' : 'ring-ecoluxe-ink/5' }} focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all text-sm">
            @error('full_name') 
                <span class="text-[10px] text-red-500 font-bold uppercase tracking-widest mt-2 ml-2 block italic">{{ $message }}</span> 
            @enderror
        </div>

        {{-- Email Field --}}
        <div>
            <input wire:model="email" type="email" placeholder="Email Address" 
                class="w-full p-4 md:p-5 bg-white rounded-2xl border-none ring-1 {{ $errors->has('email') ? 'ring-red-400' : 'ring-ecoluxe-ink/5' }} focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all text-sm">
            @error('email') 
                <span class="text-[10px] text-red-500 font-bold uppercase tracking-widest mt-2 ml-2 block italic">{{ $message }}</span> 
            @enderror
        </div>
    </div>
    
    {{-- Message Field --}}
    <div>
        <textarea wire:model="message" placeholder="Tell us about your home..." rows="4" 
            class="w-full p-4 md:p-5 bg-white rounded-2xl border-none ring-1 {{ $errors->has('message') ? 'ring-red-400' : 'ring-ecoluxe-ink/5' }} focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all text-sm"></textarea>
        @error('message') 
            <span class="text-[10px] text-red-500 font-bold uppercase tracking-widest mt-2 ml-2 block italic">{{ $message }}</span> 
        @enderror
    </div>
    
    <button type="submit" class="bg-ecoluxe-ink text-white px-10 py-5 rounded-2xl font-bold hover:bg-ecoluxe-green transition-all shadow-xl shadow-ecoluxe-ink/10 w-full lg:w-auto text-sm md:text-base disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
        <span wire:loading.remove>Send Inquiry</span>
        <span wire:loading>Authenticating Request...</span>
    </button>
</form>
    </div>
</div>
