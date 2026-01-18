<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('service_id')
                    ->numeric(),
                TextEntry::make('coupon_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('customer_name'),
                TextEntry::make('customer_email'),
                TextEntry::make('customer_phone'),
                TextEntry::make('scheduled_at')
                    ->dateTime(),
                TextEntry::make('total_rooms')
                    ->numeric(),
                TextEntry::make('subtotal')
                    ->numeric(),
                TextEntry::make('discount_amount')
                    ->numeric(),
                TextEntry::make('total_price')
                    ->money(),
                TextEntry::make('status'),
                TextEntry::make('special_instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                Section::make('Real-Time Tracking')
                ->description('The journey of your sactuary transformation')
                ->schema([
                    TextEntry::make('status')
                    ->badge()
                    ->color(fn ($state)=>match($state){
                        'in_progress'=>'primary',
                        'completed'=>'success',
                        default=>'gray',
                    }),
                    TextEntry::make('completed_at')
                    ->label('Finished At')
                    ->dateTime()
                    ->visible(fn ($record)=> $record->status == 'completed'),
                    ImageEntry::make('after_photo')
                    ->label('Final Transformation')
                    ->columnSpanFull()
                    ->size(600)
                    ->visible(fn($record)=> $record->after_photo !== null),

                ])
                ->collapsible(),

                Section::make('Professional Audit')
                        ->description('Internal quality control data')
                        ->visible(fn () => auth()->user()->role === 'admin') // Restricted to you
                        ->schema([
                            Grid::make(3)
                                ->schema([
                                    TextEntry::make('started_at')
                                        ->label('Clock In')
                                        ->dateTime('M j, g:i a'),
                                    TextEntry::make('completed_at')
                                        ->label('Clock Out')
                                        ->dateTime('M j, g:i a'),
                                    TextEntry::make('transformation_duration')
                                        ->label('Total Time Spent')
                                        ->color('success')
                                        ->weight('bold'),
                                ]),
                        ]),

                       Section::make('Internal Team Communication')
                                ->description('Logistics and coordination for this sanctuary')
                                ->visible(fn () => in_array(auth()->user()->role, ['admin', 'cleaner']))
                                ->collapsible()
                                ->schema([
                                    RepeatableEntry::make('messages')
                                    ->poll('10s')
                                        ->label('')
                                        // If the relationship is empty, we show a placeholder
                                        ->placeholder('No messages have been recorded for this booking.') 
                                        ->schema([
                                            Grid::make(2)
                                                ->schema([
                                                    TextEntry::make('user.name')
                                                        ->label('')
                                                        ->formatStateUsing(fn ($state, $record) => $record->user->role === 'admin' ? "⚜️ {$state} (Admin)" : "✨ {$state} (Professional)")
                                                        ->weight('bold')
                                                        ->color(fn ($record) => $record->user->role === 'admin' ? 'primary' : 'success'),
                                                    
                                                    TextEntry::make('created_at')
                                                        ->label('')
                                                        ->dateTime('M j, g:i A')
                                                        ->alignEnd()
                                                        ->color('gray')
                                                        ->size('xs'),
                                                        
                                                    TextEntry::make('message')
                                                        ->label('')
                                                        ->columnSpanFull()
                                                        ->extraAttributes([
                                                            'class' => 'italic text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100'
                                                        ]),
                                                ]),
                                        ])
                                        // We use columns to make it look less like a list and more like a feed
                                        ->columnSpanFull()
                                ]),
            ]);
    }
}
