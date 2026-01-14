<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Coupon;
class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
        public function run(): void
    {
        Coupon::create([
            'code' => 'FRESH2026',
            'type' => 'percent',
            'value' => 20, // 20% off
            'expires_at' => now()->addYear(),
        ]);

        Coupon::create([
            'code' => 'WELCOME50',
            'type' => 'fixed',
            'value' => 50.00, // $50 off
            'expires_at' => now()->addYear(),
        ]);
    }
    
}
