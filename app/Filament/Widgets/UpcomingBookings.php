<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Enums\FontWeight;

class UpcomingBookings extends TableWidget
{

    public static function canView(): bool
{
    // Only allow users with the 'admin' role to see this widget
    return auth()->user()?->role === 'admin';
}
   public function table(Table $table): Table
{
    return $table
        ->query(
            // Fetches bookings that aren't finished yet, ordered by the soonest first
        Booking::query()
                ->whereIn('status', ['confirmed', 'pending'])
                ->where('scheduled_at', '>=', now()) 
                ->orderBy('scheduled_at', 'asc')
        )
        ->columns([
           TextColumn::make('scheduled_at')
                ->label('Appointment')
                ->dateTime('M j, g:i a')
                // This adds the "2 hours from now" text underneath the date
                ->description(fn ($record): string => $record->scheduled_at->diffForHumans())
                ->color('primary')
                ->weight(FontWeight::Bold),

            TextColumn::make('customer_name')
                ->label('Client Name')
                ->searchable(),

            TextColumn::make('service.name')
                ->label('Package')
                ->badge()
                ->color('gray'),

            TextColumn::make('payment_status')
                ->label('Payment')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'paid' => 'success',
                    'unpaid' => 'danger',
                    'refunded' => 'warning',
                    default => 'gray',
                }),

                TextColumn::make('status')
                    ->label('Booking Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'info',
                        'pending_payment' => 'gray',
                        'completed' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('cleaners.name')
                    ->label('Assigned Crew')
                    ->badge()
                    ->listWithLineBreaks() // Displays names neatly on top of each other
                    ->color('info')
                    ->placeholder('Unassigned'),
        ])
        ->actions([
            // A simple button to go straight to the booking details
            Action::make('Manage')
                ->url(fn ($record): string => BookingResource::getUrl('view', ['record' => $record]))
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->button()
                ->size('xs'),
            Action::make('downloadInvoice')
                ->label('Invoice')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->visible(fn ($record) => $record->payment_status === 'paid')
                ->action(function ($record) {
            $pdf = Pdf::loadView('invoices.booking', ['booking' => $record]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, "EcoLuxe-Invoice-{$record->id}.pdf");
        }),
        ]);
}
}
