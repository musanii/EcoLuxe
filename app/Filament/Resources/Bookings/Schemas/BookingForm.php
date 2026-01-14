<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('service_id')
                    ->required()
                    ->numeric(),
                TextInput::make('coupon_id')
                    ->numeric(),
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_email')
                    ->email()
                    ->required(),
                TextInput::make('customer_phone')
                    ->tel()
                    ->required(),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                TextInput::make('total_rooms')
                    ->required()
                    ->numeric(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Textarea::make('special_instructions')
                    ->columnSpanFull(),
                Section::make('Staff Assignment')
                    ->schema([
                        Select::make('cleaners')
                            ->relationship('cleaners', 'name', function($query){
                                return $query->where('role', 'cleaner');
                            }) // Reference the belongsToMany relationship
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Assign Cleaning Crew')
                            ->helperText('Select one or more cleaners for this luxury service.')
                    ]),
            ]);
    }
}
