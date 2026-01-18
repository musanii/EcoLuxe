<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStats extends StatsOverviewWidget
{
    protected function getStats(): array
{
    $now = now();
    $lastMonth = now()->subMonth();

    // Current Month Revenue (Filtered by Year and Month)
    $currentMonthRevenue = Booking::where('payment_status', 'paid')
        ->whereYear('created_at', $now->year)
        ->whereMonth('created_at', $now->month)
        ->sum('total_price');

    // Last Month Revenue (Filtered by Year and Month)
    $lastMonthRevenue = Booking::where('payment_status', 'paid')
        ->whereYear('created_at', $lastMonth->year)
        ->whereMonth('created_at', $lastMonth->month)
        ->sum('total_price');

    $diff = $currentMonthRevenue - $lastMonthRevenue;

    //Recovery logic
    //A booking is "Recovered" if it was once unpaid/abandoned but is now paid
    $recoveredCount = Booking::whereNotNull('recovered_at')->count();

    //---Quality Logic--
    $avgRating = Booking::whereNotNull('rating')->avg('rating') ?? 0;

    return [

        //Revenue Stat
        Stat::make('Monthly Revenue', 'USD ' . number_format($currentMonthRevenue, 2))
            ->description($diff >= 0 
                ? 'USD ' . number_format($diff, 2) . ' increase' 
                : 'USD ' . number_format(abs($diff), 2) . ' decrease')
            ->descriptionIcon($diff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($diff >= 0 ? 'success' : 'danger')
            ->chart([7, 3, 4, 5, 6, 3, 5, 8]),
        
          //Recovery Stat
          Stat::make('Recovered Revenue',$recoveredCount)
          ->label('Sanctuaries Saved')
          ->description('Bookings rescued from abandonment')
          ->descriptionIcon('heroicon-m-arrow-path')
          ->color('info')
          ->chart([1,5,2,8,4,10]),
          
          // 3. Quality Stat (New: Customer Satisfaction)
            Stat::make('Service Quality', number_format($avgRating, 1) . ' / 5.0')
                ->description('Average customer rating')
                ->descriptionIcon('heroicon-m-star')
                ->color($avgRating >= 4.5 ? 'success' : 'warning'),
        
        Stat::make('Active Bookings', Booking::where('status', 'confirmed')->count())
            ->description('Confirmed appointments')
            ->icon('heroicon-o-calendar-days')
            ->color('info'),

        Stat::make('Pending Payments', Booking::where('payment_status', 'unpaid')->where('status', '!=', 'cancelled')->count())
            ->description('Incomplete checkouts')
            ->icon('heroicon-o-credit-card')
            ->color('warning'),
    ];
}


public static function canView(): bool
{
    // Only admins see the financial stats
    return auth()->user()->role === 'admin';
}
}
