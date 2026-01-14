<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Mail\BookingInvoice;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StripeWebhookController extends Controller
{

    public function handle(Request $request)
{
    $payload = $request->getContent();
    $sig_header = $request->header('Stripe-Signature');
    $endpoint_secret = config('services.stripe.webhook_secret');

    try {
        $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
    } catch (\Exception $e) {
        return response('Webhook Error', 400);
    }

    $session = $event->data->object;
    $bookingId = $session->metadata->booking_id ?? null;
    $booking = Booking::find($bookingId);

    if (!$booking) {
        return response('Booking not found', 404);
    }

    switch ($event->type) {
        // SCENARIO 1: Payment Successful
        case 'checkout.session.completed':
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            try {
                Mail::to($booking->customer_email)->send(new BookingInvoice($booking));
            } catch (\Exception $e) {
                \Log::error("Mail failed for booking {$booking->id}: " . $e->getMessage());
            }
            break;

        // SCENARIO 2: Payment Failed (Card Declined, etc.)
        case 'invoice.payment_failed':
        case 'checkout.session.async_payment_failed':
            $booking->update([
                'status' => 'pending_payment',
                'payment_status' => 'failed',
            ]);
            break;

        // SCENARIO 3: Session Expired (User abandoned the checkout)
        case 'checkout.session.expired':
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'unpaid',
            ]);
            break;
    }

    return response('Webhook Handled', 200);
}
    
}
