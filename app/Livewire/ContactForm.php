<?php

namespace App\Livewire;

use App\Models\Inquiry;
use App\Mail\ConciergeAutoResponder;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationACTion; // Verify plural 'Actions'
use Filament\Actions\Action;
use Livewire\Component;

class ContactForm extends Component
{

public $full_name,$email,$message;

public function sendInquiry(){
    $this->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
    ]);
    $inquiry = Inquiry::create([
        'full_name'=>$this->full_name,
        'email'=>$this->email,
        'message'=>$this->message
    ]);

    Mail::to($this->email)->send(new ConciergeAutoResponder($this->full_name));

    //FIre Notification To Admin
    Notification::make()
    ->title('New Estate Consultation Request')
    ->icon('heroicon-o-sparkles')
    ->color('error')
    ->body("New inquiry from {$this->full_name}")
    ->actions([
        Action::make('view')
        ->label('View Inquiry')
        ->button()
        ->url(fn()=>"/admin/inquiries/{$inquiry->id}/edit")
    ])
    ->sendToDatabase(User::where('role'==='admin')->get());
    $this->reset();
    session()->flash('message','Your request has been sent to our concierge.');

  

}
    public function render()
    {
        return view('livewire.contact-form');
    }
}
