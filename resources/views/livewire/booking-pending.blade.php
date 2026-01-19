<div wire:poll.3s="checkStatus" class="max-w-xl mx-auto py-20 px-6 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-ecoluxe-green/10 rounded-full mb-6 animate-pulse">
        <svg class="w-10 h-10 text-ecoluxe-green animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <h1 class="font-serif text-3xl text-ecoluxe-ink mb-4">Awaiting M-Pesa PIN...</h1>
    <p class="text-ecoluxe-ink/60 mb-8">Please check your phone. A prompt has been sent to <strong>{{ $booking->customer_phone }}</strong>.</p>
    
    <div class="bg-gray-50 rounded-2xl p-6 border border-dashed border-gray-200">
        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Transaction Reference</p>
        <code class="text-ecoluxe-ink font-mono">{{ $booking->gateway_transaction_id }}</code>
    </div>

    <p class="mt-8 text-xs text-ecoluxe-ink/40">
        Don't refresh this page. We will automatically confirm your reservation once the payment is processed.
    </p>
</div>