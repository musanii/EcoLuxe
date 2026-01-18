<?php

namespace App\Console\Commands;

use App\Mail\AbandonedBookingFollowUp;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RecoverAbandonedBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recover-abandoned-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We noticed  a technical interruption and wanted to ensure your sanctuary is still reserved.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $abandoned = Booking::whereIn('payment_status',[ 'abandoned','failed','pending_payment','unpaid'])
       ->where('created_at', '<=', now()->subMinutes(30))
       ->where('recovery_email_sent', false)
       ->get();

         foreach ($abandoned as $booking) {
              // Logic to send recovery email
               Mail::to($booking->user->email)->send(new AbandonedBookingFollowUp($booking));
    
              // Mark the booking as recovery email sent
              $booking->recovery_email_sent = true;
              $booking->save();
              Log::info("Recovery email sent to: {$booking->customer_email} for Booking #{$booking->id}");
         }
    }
}
