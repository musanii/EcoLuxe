<?php

namespace App\Filament\Resources\Subscribers;

use App\Filament\Resources\Subscribers\Pages\CreateSubscriber;
use App\Filament\Resources\Subscribers\Pages\EditSubscriber;
use App\Filament\Resources\Subscribers\Pages\ListSubscribers;
use App\Filament\Resources\Subscribers\Schemas\SubscriberForm;
use App\Filament\Resources\Subscribers\Tables\SubscribersTable;
use App\Models\Subscriber;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'subscriber';

    public static function form(Schema $schema): Schema
    {
        return SubscriberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
      return $table
        ->columns([
            TextColumn::make('email')
                ->searchable()
                ->copyable(), // Allows admin to quickly copy email
            IconColumn::make('is_active')
                ->boolean()
                ->label('Active Status'),
            TextColumn::make('created_at')
                ->dateTime()
                ->label('Joined Date'),
        ])
        ->bulkActions([
            BulkActionGroup::make([
            DeleteBulkAction::make(),
                // Pro Tip: Add an Export Bulk Action later
            ]),
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
            'index' => ListSubscribers::route('/'),
            'create' => CreateSubscriber::route('/create'),
            'edit' => EditSubscriber::route('/{record}/edit'),
        ];
    }
}
