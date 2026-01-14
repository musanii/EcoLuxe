<?php

namespace App\Mail;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $boolking;

    /**
     * Create a new message instance.
     */
    public function __construct( Booking $booking )
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your EcoLuxe Invoice - '. substr($this->booking->id,0,8),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-invoice',
            with: [
                'booking' => $this->booking,
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
        // 1. Generate the PDF using a specific blade view
        $pdf = Pdf::loadView('invoices.booking', ['booking' => $this->booking]);

        // 2. Attach it directly from data (no need to save to disk)
        return [
            Attachment::fromData(fn () => $pdf->output(), 'EcoLuxe-Invoice-' . substr($this->booking->id, 0, 8) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
