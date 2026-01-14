<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected  ?string $heading = 'Revenue Trend';
    protected  string $color = 'success';
    protected  ?string $pollingInterval = '30s';
 //protected int | string | array $columnSpan = 2;

 public static function canView(): bool
{
    // Only allow users with the 'admin' role to see this widget
    return auth()->user()?->role === 'admin';
}

    protected function getData(): array
    {

        $data = Booking::where('status', 'completed')
                ->select(
                    // DB::raw('sum(total_price) as aggregate'),
                    // DB::raw("DATE_FORMAT(created_at, '%M') as month"),
                    // DB::raw('max(created_at) as date')
                     DB::raw('sum(total_price) as aggregate'),
                      DB::raw("strftime('%m', created_at) as month_number"),
                        DB::raw("strftime('%Y-%m', created_at) as month_year")
                 )
                    ->groupBy('month')
                    ->orderBy('date')
                    ->get();
        return [
            'datasets' => [
                [
                    'label' => 'Revenue (USD)',
                    'data' => $data->pluck('aggregate'),
                     'fill'=>'start',
                     'tension'=>0.4,
                     'backgroundColor' => 'rgba(45, 64, 49, 0.1)', // Your EcoLuxe Green with transparency
                     'borderColor' => '#2D4031', // Solid EcoLuxe Green
                ],
            ],
            'labels' => $data->pluck('month'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getColumns(): int | string | array
{
    return 2;
}
}
