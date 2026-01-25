<div class="space-y-4">
    @forelse($record->responses as $response)
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold uppercase tracking-widest text-ecoluxe-gold">
                    Replied by {{ $response->admin_name }}
                </span>
                <span class="text-[10px] text-gray-400">
                    {{ $response->created_at->format('M d, Y H:i') }}
                </span>
            </div>
            <p class="text-sm text-gray-700 dark:text-gray-300 italic">
                "{!! nl2br(e($response->message)) !!}"
            </p>
        </div>
    @empty
        <p class="text-xs text-gray-400 italic">No responses sent yet.</p>
    @endforelse
</div>