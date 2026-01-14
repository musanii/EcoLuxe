<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
         @if (session()->has('message'))
                            <div id="flash-message" class="mb-6 p-4 rounded-md bg-[#F8F7F2] border border-[#C5A059] flex items-center justify-between transition-opacity duration-500">
                            <div class="flex items-center">
                            <svg class="h-5 w-5 text-[#C5A059]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="ml-3 text-sm font-medium text-[#2D4031] font-sans-lux">
                            {{ session('message') }}
                            </p>
                            </div>
                            <button onclick="document.getElementById('flash-message').style.display='none'" class="text-[#C5A059] hover:text-[#2D4031]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            </div>
                            @endif
        @if ($errors->any())
    <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
