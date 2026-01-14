<?php

use App\Services\Booking\PricingService;
use App\Models\Service;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses (RefreshDatabase::class);
beforeEach(function(){
    $this->pricingService = new PricingService();

    //setup a base service for testing
    $this->service = Service::create([
        'name' => 'EcoLuxe Essential',
        'base_price' => 120.00,
        'description' => 'Test Service',
        'estimated_minutes' => 60
    ]);
});

it('calculates the correct base price for multiple rooms', function () {
    // 120 (base) + (2 extra rooms * 30) = 180
    $result = $this->pricingService->calculate($this->service->id, 3, 'once');

    expect($result['total'])->toBe(180.00);
});

it('applies a 15% discount for weekly frequency', function () {
    // 120 base, weekly clean
    $result = $this->pricingService->calculate($this->service->id, 1, 'weekly');

    // 120 - 15% (18) = 102
    expect($result['total'])->toBe(102.00);
    expect($result['discount_amount'])->toBe(18.00);
});


it('applies a percentage coupon correctly', function () {
    $coupon = Coupon::create([
        'code' => 'SAVE20',
        'type' => 'percent',
        'value' => 20,
        'expires_at' => now()->addDay()
    ]);

    $result = $this->pricingService->calculate($this->service->id, 1, 'once', 'SAVE20');

    // 120 - 20% (24) = 96
    expect($result['total'])->toBe(96.00);
});


it('combines frequency discounts and coupons properly', function () {
    Coupon::create([
        'code' => 'FIXED10',
        'type' => 'fixed',
        'value' => 10,
        'expires_at' => now()->addDay()
    ]);

    // 120 base, weekly (15% off = 18), then $10 fixed coupon
    $result = $this->pricingService->calculate($this->service->id, 1, 'weekly', 'FIXED10');

    // 120 - 18 - 10 = 92
    expect($result['total'])->toBe(92.00);
});
