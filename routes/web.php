<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Webhook\BookingResumeController;
use App\Http\Controllers\Webhook\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Models\Booking;
use App\Livewire\BookingPending;
use App\Models\Service;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/booking/success/{booking}', function (App\Models\Booking $booking) {
//     $booking->update(['payment_status' => 'paid']);
//     return redirect('/admin/bookings/' . $booking->id); 
// })->name('booking.success')->middleware(['auth']);

Route::get('/booking/success/{booking}', function (Booking $booking) {
    // 1. Double check security
    if (auth()->user()->email !== $booking->customer_email && auth()->user()->role !== 'admin') {
        abort(403);
    }

    // 2. Mark as paid
    $booking->update(['payment_status' => 'paid']);

    // 3. Return your custom Blade view
    return view('booking-success', [
        'booking' => $booking
    ]);
})->name('booking.success')->middleware(['auth']);

Route::get('/booking/{booking}/resume', [BookingResumeController::class, 'resume'])
->name('booking.resume')
->middleware('signed');


//mpesa
Route::get('/booking/pending/{booking}', BookingPending::class)
    ->name('booking.pending');

//cancel route
Route::view('booking/cancelled','booking-cancelled')->name('booking.cancel');
Route::view('/booking/expired', 'bookings.expired')->name('booking.expired');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
Route::get('/booking/{booking}/rate', [FeedbackController::class, 'show'])->name('booking.rating');
Route::post('/booking/{booking}/rate', [FeedbackController::class, 'store'])->name('booking.rating.store');
Route::get('/dashboard', function () {
    return redirect('/admin'); 
})->middleware(['auth'])->name('dashboard');

Route::get('/services/{service:id}', function(Service $service){
    return view('services.show', compact('service'));
})->name('services.show');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
