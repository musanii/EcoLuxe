<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\Widget;
use App\Filament\Resources\Bookings\BookingResource; // Verify this path!

 //class BookingCalendar extends Widget
 //{
//     protected  string $view = 'filament.widgets.booking-calendar';
//     protected int | string | array $columnSpan = 'full';

// public function getViewData(): array
// {
//     $bookings = Booking::whereNotNull('scheduled_at')->get();

//     $events = $bookings->map(function ($booking) {
//         return [
//             'title' => "✨ {$booking->customer_name}",
//             'start' => $booking->scheduled_at->toIso8601String(),
//             'url' => "/admin/bookings/{$booking->id}",
//             'color' => '#3b82f6',
//         ];
//     })->toArray();

//     // Find the date of the first booking so the calendar can jump to it
//     $initialDate = $bookings->min('scheduled_at')?->format('Y-m-d') ?? now()->format('Y-m-d');

//     return [
//         'events' => $events,
//         'initialDate' => $initialDate,
//     ];
// }
//}