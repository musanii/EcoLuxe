<div class="mt-2">
    <form wire:submit.prevent="subscribe" class="relative group">
        <div class="relative flex items-center">
            <input 
                wire:model="email" 
                type="email" 
                placeholder="Email address" 
                class="w-full bg-transparent border-b {{ $errors->has('email') ? 'border-red-500/40' : 'border-white/10' }} py-3 pr-16 focus:outline-none focus:border-ecoluxe-gold transition-all duration-700 text-xs text-white placeholder:text-white/20 font-light italic tracking-wide"
            >
            
            <button type="submit" 
                class="absolute right-0 text-ecoluxe-gold hover:text-white transition-colors duration-500 uppercase tracking-[0.3em] text-[9px] font-bold"
                wire:loading.attr="disabled">
                
                <span wire:loading.remove>Join</span>
                <span wire:loading class="animate-pulse">...</span>
            </button>
        </div>
    </form>
</div>