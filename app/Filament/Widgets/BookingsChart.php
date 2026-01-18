<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BookingsChart extends ChartWidget
{
    protected  ?string $heading = 'Daily Sanctuary Bookings';

    public ?string $filter = 'month';

protected function getFilters(): ?array
{
    return [
        'today' => 'Today',
        'week' => 'Last 7 days',
        'month' => 'Last 30 days',
        'year' => 'This year',
    ];
}

    // This makes the chart occupy the full width if you want, 
    // or you can set it to '1/2' to sit next to another widget.
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        // Determine the start date and the aggregation period based on the filter
        $query = Trend::model(Booking::class);

        switch ($activeFilter) {
            case 'week':
                $start = now()->subDays(6);
                $data = $query->between(start: $start, end: now())->perDay()->count();
                break;
            case 'year':
                $start = now()->startOfYear();
                $data = $query->between(start: $start, end: now())->perMonth()->count();
                break;
            case 'month':
            default:
                $start = now()->subDays(29);
                $data = $query->between(start: $start, end: now())->perDay()->count();
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Bookings',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                    'tension' => 0.4,
                    'borderColor' => '#2D4031',
                    'backgroundColor' => 'rgba(45, 64, 49, 0.1)',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $activeFilter === 'year' 
                ? Carbon::parse($value->date)->format('M') 
                : Carbon::parse($value->date)->format('M j')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}