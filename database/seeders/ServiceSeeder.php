<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'EcoLuxe Essential',
                'description' => 'Our signature non-toxic standard clean.',
                'base_price' => 120.00,
                'estimated_minutes' => 180,
            ],
            [
                'name' => 'Deep Polish',
                'description' => 'Detailed cleaning including baseboards and inside windows.',
                'base_price' => 250.00,
                'estimated_minutes' => 360,
            ],
            [
                'name' => 'The Fresh Start',
                'description' => 'Move-in/Move-out deep restoration.',
                'base_price' => 450.00,
                'estimated_minutes' => 600,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
