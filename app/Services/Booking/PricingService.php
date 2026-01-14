<?php

namespace App\Services\Booking;

use  App\Models\Booking;
use App\Models\Coupon;
use App\Models\Service;

class PricingService {
    /**
     * Calculate the final Price including rooms, frequency and discounts.
     */

    public function calculate(int $serviceId, int $rooms, string $frequency, ?string $couponCode=NULL){
       
       
  

        $service = Service::findOrFail($serviceId);

        //1 Base Logic
        $subtotal = $service->base_price +(($rooms -1) * 30); //Assuming each additional room is $30
        $frequencyDiscount = match($frequency){
            'weekly' => 0.15, //15% off
            'bi-weekly' => 0.10, //10% off
            default => 0.0,
        };

        $discountAmount = $subtotal * $frequencyDiscount;

        //Apply coupon if exists
        if($couponCode){
            $coupon = Coupon::where('code',$couponCode)->where('expires_at','>',now())->first();
            if ($coupon) {
                $couponDiscount = ($coupon->type === 'percent') 
                    ? ($subtotal - $discountAmount) * ($coupon->value / 100) 
                    : $coupon->value;
                $discountAmount += $couponDiscount;
            }
        }
        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total' => max(0, $subtotal - $discountAmount),
        ];

    }
}