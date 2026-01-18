<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class BookingResumeController extends Controller
{
    public function resume(Booking $booking)
    {
       //IF already paid send to success page
         if($booking->payment_status ==='paid'){
            return redirect()->route('booking.success', ['booking' => $booking->id]);
         }

         //Date Check: If appointment is in the past, they must pick a new date
         if($booking->scheduled_at->isPast()){
            return redirect('home')->with('message','Your previous appointment time has passed. Please select a new date to continue.');

         }

         //Re-initiate Stripe session
         Stripe::setApiKey(config('services.stripe.secret'));
         $session = Session::create([
            'customer_email' => $booking->customer_email,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'EcoLuxe Cleaning: ' . ($booking->service->name),
                        'description' => $booking->total_rooms . ' Rooms - Resume Reservation',
                    ],
                    'unit_amount' => (int) round($booking->total_price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('booking.success', $booking->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('booking.cancel'),
            'metadata' => ['booking_id' => $booking->id],
        ]);

        // Update the booking with the new session ID
        $booking->update([
            'stripe_session_id' => $session->id,
            'recovered_at'=>now()
            ]);

        return redirect($session->url);
    

    }
}
