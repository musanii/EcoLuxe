<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;

class MpesaService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.mpesa.env') === 'live'
        ? 'https://api.safaricom.co.ke'
        : 'https://sandbox.safaricom.co.ke';
    }

    // protected function getAccessToken()
    // {
    //     $response = Http::withBasicAuth(
    //         config('services.mpesa.key'),
    //         config('services.mpesa.secret')

    //     )->get("{$this->baseUrl}/oauth/v1/generate?grant_type=client_credentials");

    // }

    protected function getAccessToken()
{
    // 1. Ensure keys are trimmed of any accidental spaces
    $key = trim(config('services.mpesa.key'));
    $secret = trim(config('services.mpesa.secret'));

    // 2. Make the request to the correct environment
    $response = Http::withBasicAuth($key, $secret)
        ->get("{$this->baseUrl}/oauth/v1/generate?grant_type=client_credentials");

    if ($response->failed()) {
        throw new \Exception("Mpesa Auth Failed: " . $response->body());
    }

    return $response->json()['access_token'];
}

    public function initiateStkPush($phone, $amount,$reference){
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(
            config('services.mpesa.shortcode') .
            config('services.mpesa.passkey') . 
            $timestamp

        );

        //Standadize phone to 2547XXXXXX
        $phone ='254' . substr(preg_replace('/\D/', '', $phone), -9);

        $response = Http::withToken($this->getAccessToken())
        ->post("{$this->baseUrl}/mpesa/stkpush/v1/processrequest",[
            'BusinessShortCode' => config('services.mpesa.shortcode'),
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int)$amount,
                'PartyA' => $phone,
                'PartyB' => config('services.mpesa.shortcode'),
                'PhoneNumber' => $phone,
                'CallBackURL' => config('services.mpesa.callback'),
                'AccountReference' => 'EcoLuxe Cleaning',
                'TransactionDesc' => "Payment for Booking {$reference}",
        ]);
        return $response->json();
    }
}
