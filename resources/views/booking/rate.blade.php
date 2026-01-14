<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-auto">
            <div class="flex justify-center">
                <h2 style="color: #2D4031; text-align: center; margin-bottom: 5px; font-weight: 400; letter-spacing: 4px;">ECOLUXE</h2>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                How did we do?
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Booking #{{ substr($booking->id, 0, 8) }} - {{ $booking->service->name }}
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border-t-4 border-[#2c5f2d]">
                <form action="{{ route('booking.rating.store', $booking->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 text-center mb-4">
                            Your Rating
                        </label>
                        <div class="flex items-center justify-center space-x-2 flex-row-reverse">
                            @foreach(range(5, 1) as $i)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <label for="star{{ $i }}" class="cursor-pointer text-4xl text-gray-300 peer-hover:text-[#9c8412] peer-checked:text-[#9c8412] transition-colors">
                                    ★
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">
                            Tell us more (Optional)
                        </label>
                        <div class="mt-1">
                            <textarea id="comment" name="feedback_comment" rows="4" 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2c5f2d] focus:border-[#2c5f2d] sm:text-sm"
                                placeholder="What did you love? Anything we could improve?"></textarea>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#2c5f2d] hover:bg-[#1e421f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c5f2d] transition-all">
                            Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* This logic handles the "hover effect" for stars to light up all stars to the left of the hovered one */
        .stars label:hover,
        .stars label:hover ~ label,
        .stars input:checked ~ label {
            color: #9c8412;
        }
    </style>
</x-guest-layout>