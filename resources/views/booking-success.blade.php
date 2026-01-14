<x-layouts.app>
    <div class="max-w-4xl mx-auto py-20 px-6">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-ecoluxe-green/10 rounded-full mb-6">
                <svg class="w-10 h-10 text-ecoluxe-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="font-serif text-4xl md:text-5xl text-ecoluxe-ink mb-4">Reservation Confirmed</h1>
            <p class="text-ecoluxe-ink/60 text-lg">Your space is about to be transformed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="md:col-span-2 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h3 class="font-serif text-2xl mb-6 text-ecoluxe-ink">Cleaning Details</h3>
                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-ecoluxe-ink/50 uppercase text-[10px] font-bold tracking-widest">Service</span>
                        <span class="font-bold text-ecoluxe-ink">{{ $booking->service->name }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-50">
                        <span class="text-ecoluxe-ink/50 uppercase text-[10px] font-bold tracking-widest">Scheduled For</span>
                        <span class="font-bold text-ecoluxe-ink">{{ $booking->scheduled_at->format('M j, Y @ g:i a') }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-ecoluxe-ink/50 uppercase text-[10px] font-bold tracking-widest">Amount Paid</span>
                        <span class="font-bold text-ecoluxe-green">${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-ecoluxe-ink rounded-3xl p-8 text-white">
                <h3 class="font-serif text-xl mb-6">What's Next?</h3>
                <ul class="space-y-4 text-sm text-white/70">
                    <li class="flex gap-3">
                        <span class="text-ecoluxe-gold font-bold">01.</span>
                        <span>You'll receive a confirmation email with your invoice.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-ecoluxe-gold font-bold">02.</span>
                        <span>Our team will arrive at your location on time.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-ecoluxe-gold font-bold">03.</span>
                        <span>Manage your booking via your new <a href="/admin/bookings" class="text-white underline decoration-ecoluxe-gold">Customer Portal</a>.</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center">
            <a href="/" class="text-[11px] font-bold uppercase tracking-[0.2em] text-ecoluxe-ink/40 hover:text-ecoluxe-green transition">
                Return to Homepage
            </a>
        </div>
    </div>
</x-layouts.app>