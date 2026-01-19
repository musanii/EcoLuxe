<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Filament\Resources\Services\Schemas\ServiceForm;
use App\Filament\Resources\Services\Tables\ServicesTable;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Management')
                    ->description('Manage pricing and availability for EcoLuxe tiers.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->rows(3),
                        TextInput::make('base_price')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        TextInput::make('estimated_minutes')
                            ->numeric()
                            ->label('Duration (Mins)')
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->weight('bold'),
              TextColumn::make('base_price')
                ->money('USD ')
                ->sortable()
                ->color('success'),
              TextColumn::make('estimated_minutes')
                ->label('Time')
                ->formatStateUsing(fn ($state) => "{$state} mins")
                ->sortable(),
              ToggleColumn::make('is_active')
                ->label('Active'),
              TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
       
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ])
        ->headerActions([
    Action::make('holiday_markup')
        ->label('Apply Price Change')
        ->icon('heroicon-o-currency-dollar')
        // This adds a text box to the confirmation popup!
        ->form([
            TextInput::make('amount')
                ->label('Increase/Decrease amount ($)')
                ->numeric()
                ->required(),
        ])
        ->action(function (array $data) {
            Service::query()->increment('base_price', $data['amount']);
            
        Notification::make()
                ->title('Prices Updated Successfully')
                ->success()
                ->send();
        }),
]);
            
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }

        public static function canViewAny(): bool
            {
                // Hides the "Users" link from the sidebar for non-admins
                return auth()->user()?->role === 'admin';
            }
}
