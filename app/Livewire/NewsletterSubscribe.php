<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    public $email;

    public function subscribe(){
        try {
            $this->validate([
                'email' => 'required|email|unique:subscribers,email',
            ]);

            Subscriber::create(['email' => $this->email]);

            $this->reset('email');
$this->dispatch('alert', ['message' => 'It works!']);
            // Success Toast
            Notification::make()
                ->title('Welcome to the Inner Circle')
                ->body('Your membership has been verified.')
                ->success()
                ->send();

        } catch (ValidationException $e) {
            // Error Toast (if email exists or is invalid)
            Notification::make()
                ->title('Subscription Failed')
                ->body($e->validator->errors()->first('email'))
                ->danger()
                ->send();
            
            throw $e;
        }
    }
    

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
