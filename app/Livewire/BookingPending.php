<?php
namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;

class BookingPending extends Component
{
    public $booking;

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
    }

    // This function runs every time the browser "polls" the server
    public function checkStatus()
    {
        // Freshly pull the booking from the DB to see if the Webhook updated it
        $this->booking->refresh();

        if ($this->booking->payment_status === 'paid') {
            return redirect()->route('booking.success', $this->booking->id);
        }

        if ($this->booking->payment_status === 'failed') {
            session()->flash('error', 'Payment was unsuccessful. Please try again.');
            return redirect()->route('booking.calculator');
        }
    }

    public function render()
    {
        return view('livewire.booking-pending')->layout('components.layouts.app');
    }
}