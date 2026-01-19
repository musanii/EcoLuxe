{{-- PROGRESS INDICATOR --}}
<div class="max-w-7xl mx-auto relative"> 

    {{-- 1. Progress Bar (Now safely inside the root div) --}}
    <div class="mb-12 px-4 md:px-6">
        <div class="flex justify-between items-center mb-4">
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] {{ $step === 1 ? 'text-ecoluxe-green' : 'text-ecoluxe-ink/40' }}">01. Selections</span>
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] {{ $step === 2 ? 'text-ecoluxe-green' : 'text-ecoluxe-ink/40' }}">02. Details</span>
            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-ecoluxe-ink/20">03. Payment</span>
        </div>
        <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-ecoluxe-green transition-all duration-700 ease-in-out" 
                 style="width: {{ $step === 1 ? '33.33%' : '66.66%' }}"></div>
        </div>
    </div>

<div class="max-w-7xl mx-auto">
    @if($step === 1)
        {{-- STEP 1: CALCULATOR --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 p-4 md:p-6 lg:p-2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4">
            
            <div class="space-y-8 md:space-y-10 order-2 lg:order-1">
                {{-- 1. Select Service --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-ecoluxe-gold mb-4 md:mb-6">1. Select Service</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                        @foreach($services as $service)
                            <button 
                                type="button"
                                wire:click="selectService({{ $service->id }})"
                                class="relative text-left p-5 md:p-6 rounded-2xl border-2 transition-all duration-300 {{ $selectedServiceId == $service->id ? 'border-ecoluxe-green bg-ecoluxe-green/[0.02] ring-4 ring-ecoluxe-green/5' : 'border-gray-100 hover:border-ecoluxe-green/30' }}">
                                
                                <div class="flex justify-between items-start">
                                    <div class="pr-4">
                                        <p class="font-serif text-lg md:text-xl font-bold text-ecoluxe-ink leading-tight">{{ $service->name }}</p>
                                        <p class="text-[11px] text-ecoluxe-ink/40 mt-1 uppercase tracking-wider">From ${{ number_format($service->base_price, 2) }}</p>
                                    </div>
                                    @if($selectedServiceId == $service->id)
                                        <div class="bg-ecoluxe-green text-white p-1 rounded-full shrink-0">
                                            <svg class="w-3 h-3 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Scope --}}
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 lg:bg-transparent lg:p-0 lg:border-none">
                    <div class="flex justify-between mb-6">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-ecoluxe-gold">2. Scope of Work</label>
                        <span class="text-sm font-bold text-ecoluxe-green px-3 py-1 bg-ecoluxe-green/10 rounded-full">{{ $rooms }} {{ Str::plural('Room', $rooms) }}</span>
                    </div>
                    <input type="range" wire:model.live="rooms" min="1" max="12" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-ecoluxe-green">
                    <div class="flex justify-between mt-3 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                        <span>1 Room</span>
                        <span>12 Rooms</span>
                    </div>
                </div>

                {{-- 3. Frequency --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-ecoluxe-gold mb-4 md:mb-6">3. Frequency</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach(['once' => 'One-time', 'weekly' => 'Weekly', 'bi-weekly' => 'Bi-weekly'] as $value => $label)
                            <button 
                                type="button"
                                wire:click="$set('frequency', '{{ $value }}')"
                                class="py-4 sm:py-3 px-2 rounded-xl text-[10px] font-bold uppercase tracking-[0.15em] border transition-all {{ $frequency === $value ? 'bg-ecoluxe-ink text-white border-ecoluxe-ink shadow-lg shadow-ecoluxe-ink/20' : 'bg-white text-ecoluxe-ink/40 border-gray-100 hover:border-ecoluxe-green hover:text-ecoluxe-green' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- STICKY SUMMARY SIDEBAR --}}
            <div class="lg:sticky lg:top-8 order-1 lg:order-2 h-fit">
                <div class="bg-ecoluxe-cream rounded-[2rem] p-8 md:p-10 flex flex-col shadow-xl shadow-ecoluxe-ink/5 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-serif text-2xl md:text-3xl mb-8 md:mb-10 text-ecoluxe-ink">Your Investment</h3>
                        
                        <div class="space-y-5">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-ecoluxe-ink/50 font-medium tracking-wide">Standard Restoration</span>
                                <span class="font-bold text-ecoluxe-ink text-base">${{ number_format($quote['subtotal'], 2) }}</span>
                            </div>
                            
                            @if($quote['discount_amount'] > 0)
                                <div class="flex justify-between items-center text-ecoluxe-green text-sm">
                                    <span class="font-medium tracking-wide">Frequency Appreciation</span>
                                    <span class="font-bold">−${{ number_format($quote['discount_amount'], 2) }}</span>
                                </div>
                            @endif

                            <div class="pt-6 border-t border-ecoluxe-ink/10">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-ecoluxe-gold mb-1">Total Quote</p>
                                        <p class="text-4xl md:text-5xl font-serif font-bold text-ecoluxe-ink leading-none">
                                            <span class="text-2xl md:text-3xl font-sans shrink-0">$</span>{{ number_format($quote['total'], 2) }}
                                        </p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="text-[9px] text-ecoluxe-ink/40 italic leading-tight uppercase tracking-tighter">
                                            Tax included.<br>Eco-friendly products verified.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button wire:click="proceedToDetails" class="mt-8 md:mt-12 w-full bg-ecoluxe-green text-white py-5 md:py-6 rounded-2xl font-bold uppercase tracking-[0.2em] text-[10px] md:text-xs hover:bg-ecoluxe-ink transition-all duration-500 shadow-xl shadow-ecoluxe-green/20 group flex items-center justify-center gap-3">
                            Proceed to Schedule
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>

                    <div class="absolute -bottom-12 -right-12 text-ecoluxe-green/[0.04] rotate-12 pointer-events-none">
                        <svg class="w-48 h-48 md:w-64 md:h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- STEP 2: DETAILS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 p-4 md:p-6 lg:p-2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-8">
            
            <div class="space-y-8 order-2 lg:order-1">
                <button wire:click="$set('step', 1)" class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-ink/40 hover:text-ecoluxe-green transition flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg> Back to Selections
                </button>

                <h2 class="font-serif text-3xl text-ecoluxe-ink">Reservation Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2">Full Name</label>
                        <input type="text" wire:model="customer_name" class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green transition-all outline-none shadow-sm">
                        @error('customer_name') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2 flex justify-between">
                        Email Address
                        @if($emailVerified && !$isReturningClient)
                            <span class="text-ecoluxe-green flex items-center gap-1 normal-case tracking-normal">Verified</span>
                        @endif
                    </label>

                    <input type="email" wire:model.live.blur="customer_email" 
                        class="w-full p-5 bg-white rounded-2xl border-none ring-1 {{ $isReturningClient ? 'ring-ecoluxe-gold' : 'ring-ecoluxe-ink/5' }} focus:ring-2 focus:ring-ecoluxe-green outline-none transition-all shadow-sm">

                    {{-- Returning Client Alert --}}
                    @if($isReturningClient)
                        <div x-transition class="mt-3 p-4 bg-ecoluxe-gold/5 border border-ecoluxe-gold/20 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-ecoluxe-gold shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"/>
                            </svg>
                            <div>
                                <p class="text-[11px] font-bold text-ecoluxe-ink uppercase tracking-wider">Welcome back</p>
                                <p class="text-[10px] text-ecoluxe-ink/60 leading-tight">We recognize your details from a previous visit. Your profile has been updated automatically.</p>
                            </div>
                        </div>
                    @endif
                    
                </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2">Phone</label>
                        <input type="text" wire:model="customer_phone" class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green transition-all outline-none shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2">Schedule Date</label>
                        <input type="date" wire:model="scheduled_at" class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green transition-all outline-none shadow-sm">
                        @error('scheduled_at') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p> @enderror
                    </div>
                </div>
             {{-- City Select --}}
<div class="space-y-2">
    <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2">City</label>
    <select wire:model.live="city" class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green outline-none appearance-none">
        <option value="">Select City</option>
        @foreach(array_keys($cities) as $cityName)
            <option value="{{ $cityName }}">{{ $cityName }}</option>
        @endforeach
    </select>
</div>

{{-- Zip Code Select --}}
<div class="space-y-2">
    <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2 flex justify-between">
        Postal Code
        {{-- This spinner appears ONLY when the 'city' is being processed --}}
        <span wire:loading wire:target="city" class="text-ecoluxe-green animate-pulse normal-case tracking-normal">
            Fetching codes...
        </span>
    </label>
    
    <div class="relative">
        <select wire:model="zip_code" 
            class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green outline-none appearance-none {{ empty($availableZipCodes) ? 'opacity-50 pointer-events-none' : '' }}">
            <option value="">Select Code</option>
            @foreach($availableZipCodes as $code => $name)
                <option value="{{ $code }}">{{ $code }} ({{ $name }})</option>
            @endforeach
        </select>
        
        {{-- Optional: Add a chevron icon that disappears when loading --}}
        <div wire:loading.remove wire:target="city" class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none opacity-30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
        </div>
    </div>
</div>

{{-- Street Address (Full Width) --}}
<div class="md:col-span-2 space-y-2">
    <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2">Street Address / Estate</label>
    <input type="text" wire:model="address" placeholder="e.g. Riverside Drive, Acacia Court" class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green outline-none shadow-sm">
</div>

{{-- 4. Payment Method Selection --}}
<div class="space-y-4">
    <label class="block text-[10px] font-bold uppercase tracking-[0.2em] text-ecoluxe-gold mb-4">4. Preferred Payment</label>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Stripe Option --}}
        <button type="button" 
            wire:click="$set('payment_method', 'stripe')"
            class="flex items-center gap-4 p-5 rounded-2xl border-2 transition-all {{ $payment_method === 'stripe' ? 'border-ecoluxe-green bg-ecoluxe-green/5' : 'border-gray-100' }}">
            <div class="p-2 bg-white rounded-lg shadow-sm">
                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V10h16v8z"/></svg>
            </div>
            <div class="text-left">
                <p class="text-xs font-bold text-ecoluxe-ink uppercase tracking-wider">Card / Stripe</p>
                <p class="text-[10px] text-ecoluxe-ink/40">Secure Global Payment</p>
            </div>
        </button>

        {{-- M-Pesa Option --}}
        <button type="button" 
            wire:click="$set('payment_method', 'mpesa')"
            class="flex items-center gap-4 p-5 rounded-2xl border-2 transition-all {{ $payment_method === 'mpesa' ? 'border-ecoluxe-green bg-ecoluxe-green/5' : 'border-gray-100' }}">
            <div class="p-2 bg-white rounded-lg shadow-sm">
                <span class="text-green-600 font-black text-xs">M</span>
            </div>
            <div class="text-left">
                <p class="text-xs font-bold text-ecoluxe-ink uppercase tracking-wider">M-Pesa STK</p>
                <p class="text-[10px] text-ecoluxe-ink/40">Direct Mobile Money</p>
            </div>
        </button>
    </div>
    @error('payment_method') <p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p> @enderror
</div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-widest text-ecoluxe-gold ml-2">Special Notes</label>
                    <textarea wire:model="special_instructions" rows="4" class="w-full p-5 bg-white rounded-2xl border-none ring-1 ring-ecoluxe-ink/5 focus:ring-2 focus:ring-ecoluxe-green transition-all outline-none shadow-sm"></textarea>
                </div>

                
            </div>

            {{-- THE SUMMARY STAYS VISIBLE ON STEP 2 --}}
            <div class="lg:sticky lg:top-8 order-1 lg:order-2 h-fit">
    <div class="bg-ecoluxe-ink rounded-[2rem] p-8 md:p-10 text-white relative overflow-hidden">
        <h3 class="font-serif text-2xl mb-6">Reservation Summary</h3>
        
        <div class="space-y-4 text-sm opacity-80">
            <div class="flex justify-between items-center">
                <span>Service</span>
                <span class="font-bold text-ecoluxe-green">Restoration</span>
            </div>
            <div class="flex justify-between items-center">
                <span>Frequency</span>
                <span class="font-bold uppercase tracking-widest">{{ $frequency }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span>Scope</span>
                <span class="font-bold">{{ $rooms }} Rooms</span>
            </div>

            {{-- Location-based Transport Fee --}}
            @if(isset($quote['transport_fee']) && $quote['transport_fee'] > 0)
                <div class="flex justify-between items-center pt-2 border-t border-white/5">
                    <span class="flex items-center gap-2">
                        Transport ({{ $city }})
                        <svg class="w-3 h-3 text-ecoluxe-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <span class="font-bold text-ecoluxe-green">+${{ number_format($quote['transport_fee'], 2) }}</span>
                </div>
            @endif
        </div>

        <div class="mt-8 pt-8 border-t border-white/10 flex justify-between items-center">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold uppercase tracking-widest text-white/40">Total Amount</span>
                <span class="text-xs text-ecoluxe-green/60 italic">Secure Checkout</span>
            </div>
            <span class="text-3xl font-serif text-ecoluxe-green">${{ number_format($quote['total'], 2) }}</span>
        </div>

        <button wire:click="finalizeBooking" 
                wire:loading.attr="disabled" 
                class="mt-8 w-full bg-white text-ecoluxe-ink py-5 rounded-2xl font-bold uppercase tracking-widest text-[10px] hover:bg-ecoluxe-green hover:text-white transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed group">
            
            <span wire:loading.remove wire:target="finalizeBooking" class="flex items-center justify-center gap-2">
                Finalize Booking
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </span>

            <span wire:loading wire:target="finalizeBooking" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-ecoluxe-ink" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
        </button>
        
        {{-- Aesthetic Background Pattern --}}
        <div class="absolute -bottom-6 -right-6 text-white/[0.03] pointer-events-none">
            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
        </div>
    </div>
</div>
        </div>
    @endif
</div>