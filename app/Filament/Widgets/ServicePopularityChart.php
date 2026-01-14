<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ServicePopularityChart extends ChartWidget
{
    protected ?string $heading = 'Service Popularity';
    protected ?string $maxHeight ='300px';
    //protected int | string | array $columnSpan = 1;

    public static function canView(): bool
{
    // Only allow users with the 'admin' role to see this widget
    return auth()->user()?->role === 'admin';
}

    protected function getData(): array
    {
        $data = Booking::join('services', 'bookings.service_id', '=', 'services.id')
                 ->select('services.name', DB::raw('count(*) as count'))
                ->groupBy('services.name')
                ->get();
        return [
            'datasets' => [
                [
                    'label' => 'Bookings',
                    'data' => $data->pluck('count'),
                    'backgroundColor' => [
                        '#2D4031', // EcoLuxe Green
                        '#4A6B50', // Lighter EcoLuxe Green
                        '#8BA888', // Light leaf
                        '#C1D1C1', // Silver mist
                    ],
                ],
            ],
            'labels' => $data->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getColumns(): int | string | array
{
    return 1;
}
}
