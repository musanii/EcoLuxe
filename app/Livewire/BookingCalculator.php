<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Mail\BookingInvoice;
use App\Services\Booking\PricingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class BookingCalculator extends Component
{
    // Step tracking
    public $step = 1; 

    // Calculation properties
    public $selectedServiceId;
    public $rooms = 1;
    public $frequency = 'once';
    public $couponCode = '';

    // Quote data
    public $quote = [
        'subtotal' => 0,
        'discount_amount' => 0,
        'total' => 0,
    ];

    // Customer & Address Details
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $scheduled_at;
    public $special_instructions;
    
    // Address Properties (Crucial for wire:model)
    public $address;
    public $city;
    public $zip_code;

    // UI State
    public $emailVerified = false;
    public $isReturningClient = false;
    public $availableZipCodes = [];

    // Kenyan Location Data
    public $cities = [
        'Nairobi' => ['00100' => 'GPO', '00502' => 'Karen', '00625' => 'Kangemi', '00606' => 'Sarit'],
        'Mombasa' => ['80100' => 'Mombasa GPO', '80101' => 'Bamburi', '80107' => 'Nyali'],
        'Kisumu'  => ['40100' => 'Kisumu GPO', '40102' => 'Kondele'],
        'Nakuru'  => ['20100' => 'Nakuru GPO', '20117' => 'Naivasha'],
        'Eldoret' => ['30100' => 'Eldoret GPO']
    ];

    public function mount() 
    {
        $defaultService = Service::where('is_active', true)->first();
        if ($defaultService) {
            $this->selectedServiceId = $defaultService->id;
            $this->updateQuote();
        }

        if (Auth::check()) {
            $this->customer_name = Auth::user()->name;
            $this->customer_email = Auth::user()->email;
            // Trigger returning client logic for logged in users
            $this->updated('customer_email');
        }
    }

    /**
     * Single entry point for all reactive updates
     */
    public function updated($propertyName) 
    {
        // 1. Always keep the quote fresh
        $this->updateQuote();

        // 2. Handle City Selection -> Populate Zip Codes
        if ($propertyName === 'city') {
            $this->availableZipCodes = $this->cities[$this->city] ?? [];
            $this->zip_code = ''; // Reset selection for safety
        }

        // 3. Handle Email Entry -> Effortless Prefill
        if ($propertyName === 'customer_email') {
            $this->isReturningClient = false;
            
            try {
                $this->validateOnly('customer_email', ['customer_email' => 'required|email']);
                $this->emailVerified = true;

                $lastBooking = Booking::where('customer_email', $this->customer_email)
                    ->latest()
                    ->first();

                if ($lastBooking) {
                    $this->isReturningClient = true;
                    $this->customer_name = $lastBooking->customer_name;
                    $this->customer_phone = $lastBooking->customer_phone;
                    $this->address = $lastBooking->address;
                    $this->city = $lastBooking->city;
                    
                    // Manually populate the zip dropdown based on retrieved city
                    $this->availableZipCodes = $this->cities[$this->city] ?? [];
                    $this->zip_code = $lastBooking->zip_code;
                }
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->emailVerified = false;
            }
        }
    }

    public function selectService($id) 
    {
        $this->selectedServiceId = $id;
        $this->updateQuote();
    }

public function updateQuote() 
{
    if (!$this->selectedServiceId) return;

    $pricing = new PricingService();
    $baseQuote = $pricing->calculate(
        (int) $this->selectedServiceId, 
        (int) $this->rooms, 
        $this->frequency, 
        $this->couponCode
    );

    // Dynamic Transport Logic
    $transportFees = [
        'Nairobi' => 0,
        'Mombasa' => 15, 
        'Kiambu'  => 5,
        'Nakuru'  => 20,
        'Eldoret' => 25,
    ];

    $surcharge = $transportFees[$this->city] ?? 0;

    $this->quote = [
        'subtotal' => $baseQuote['subtotal'],
        'discount_amount' => $baseQuote['discount_amount'],
        'transport_fee' => $surcharge,
        'total' => ($baseQuote['subtotal'] - $baseQuote['discount_amount']) + $surcharge,
    ];
}

    public function proceedToDetails()
    {
        $this->step = 2;
    }

    public function finalizeBooking()
    {
        $this->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'address' => 'required|string|min:5', 
            'city' => 'required|string',
            'zip_code' => 'required|string',
            'scheduled_at' => 'required|date|after:today',
        ]);

        $user = User::firstOrCreate(
            ['email' => $this->customer_email],
            [
                'name' => $this->customer_name,
                'password' => Hash::make(Str::random(16)),
                'role' => 'customer',
            ]
        );

        Auth::login($user, true);

        if (!$user->role) {
            $user->update(['role' => 'customer']);
        }

        $booking = Booking::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'service_id' => $this->selectedServiceId,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'address' => $this->address,      
            'city' => $this->city,            
            'zip_code' => $this->zip_code,
            'scheduled_at' => $this->scheduled_at,
            'total_rooms' => $this->rooms,
            'subtotal' => $this->quote['subtotal'],
            'discount_amount' => $this->quote['discount_amount'],
            'total_price' => $this->quote['total'],
            'special_instructions' => $this->special_instructions,
            'payment_status' => 'pending_payment',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'customer_email' => $this->customer_email,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'EcoLuxe Cleaning: ' . ($booking->service->name ?? 'Standard Service'),
                        'description' => $this->rooms . ' Rooms - ' . ucfirst($this->frequency),
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

        $booking->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function render()
    {
        return view('livewire.booking-calculator', [
            'services' => Service::where('is_active', true)->get()
        ]);
    }
}