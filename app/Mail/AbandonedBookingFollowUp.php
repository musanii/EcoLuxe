<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbandonedBookingFollowUp extends Mailable
{
    use Queueable, SerializesModels;
        public $booking;

    /**
     * Create a new message instance.
     */
  
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Is your sanctuary still waiting?',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        //Generate the secure , Signed  URL
        $resumeUrl = URL::temporarySignedRoute(
            'booking.resume',
            now()->addDays(3),
            ['booking' => $this->booking->id]
        );
        return new Content(
            view: 'emails.abandoned-booking',
             with: [
                'booking' => $this->booking,
                'resumeUrl' => $resumeUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
