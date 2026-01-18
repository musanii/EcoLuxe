<?php

namespace App\Observers;

use App\Mail\CleanerAssignedNotification;
use App\Mail\CleanerCompleted;
use App\Mail\CleanerOnTheWay;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "updated" event.
     */
public function saved(Booking $booking): void
{
    // Refresh the relationship to make sure we see the newly synced cleaners
    $booking->load('cleaners');

    if ($booking->cleaners->isEmpty()) {
        Log::info("Observer ran for Booking #{$booking->id}, but the cleaners list is empty.");
        return;
    }

    foreach ($booking->cleaners as $cleaner) {
        if($booking->status ==='confirmed') {
        // We add a tiny flag to avoid double-sending if you save twice
        Log::info("Attempting to send assignment email to: {$cleaner->email}");
        
        Mail::to($cleaner->email)->send(new CleanerAssignedNotification($booking));
        }
    }
}

public function updated(Booking $booking){
    //only trigger if the status column was changed
    if($booking->wasChanged('status')){
        //1. When cleaner clicks "On My_Way"
        if ($booking->status === 'on_the_way'){
            Mail::to($booking->customer_email)->send(new CleanerOnTheWay($booking));
            Log::info("Customer notified: Cleaner is on the way for Booking #{$booking->id}");
        }

        // 2. When cleaner clicks "Mark Finished"
            if ($booking->status === 'completed') {
                Mail::to($booking->customer_email)->send(new CleanerCompleted($booking));
                Log::info("Customer notified: Job completed for Booking #{$booking->id}");
            }
    }

    /**
         * SPECIAL CASE: If Admin switches status to 'confirmed' via the edit form
         * and cleaners are already attached.
         */
        if ($booking->wasChanged('status') && $booking->status === 'confirmed') {
            $this->notifyCleaners($booking);
        }
}
    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }

    /**
     * Logic to notify cleaners when admin changes status to 'confirmed'
     */

    private function notifyCleaners(Booking $booking): void
    {
        // Load cleaners relationship if not already loaded
        $booking->load('cleaners');

        foreach ($booking->cleaners as $cleaner) {
            Log::info("Notifying cleaner {$cleaner->email} for Booking #{$booking->id} due to admin status change.");
            Mail::to($cleaner->email)->send(new CleanerAssignedNotification($booking));
            Log::info("Assignment email sent to cleaner: {$cleaner->email}");
        }
    }
}
