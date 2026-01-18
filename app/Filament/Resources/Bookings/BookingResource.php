<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Pages\ViewBooking;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Schemas\BookingInfolist;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use App\Models\BookingMessage;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;
use Illuminate\Support\Str;


class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'customer_name';

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    

    public static function infolist(Schema $schema): Schema
    {
        return BookingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('user_id')
                ->searchable(),
                TextColumn::make('service.name')
                ->label('Service Tier')
                ->badge()
                ->color('gray')
                ->searchable(),
                TextColumn::make('customer_name')
                ->description(fn (Booking $record) => $record->customer_email)
                    ->badge(fn (Booking $record) => 
                        $record->messages()->whereNull('read_at')->where('user_id', '!=', auth()->id())->count() ?: null
                    )
                    ->color('danger') // Red badge for unread counts
                    ->searchable(),
                TextColumn::make('customer_email')
                ->searchable(),
                   TextColumn::make('customer_phone')
                ->searchable(),
                   TextColumn::make('scheduled_at')
                   ->dateTime('M j,Y @ g:i a')
                ->sortable(),
                   TextColumn::make('total_rooms')
                ->searchable(),
                   TextColumn::make('discount_amount')         
                ->searchable(),
                 TextColumn::make('payment_status')
                ->searchable(),
                TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'gray',
                    'confirmed' => 'success',
                    'on_the_way'=>'warning',
                    'in_progress'=>'primary',
                    'completed' => 'info',
                    'canceled' => 'danger',
                    default => 'gray',
                }), 
                TextColumn::make('total_price')
                ->money('usd'),
                TextColumn::make('rating')
                    ->label('Customer Rating')
                    ->alignCenter()
                    ->formatStateUsing(function($state){
                        if(!$state) return 'Not Rated';
                        return str_repeat('★', $state) . str_repeat('☆', 5 - $state);
                    })
                    ->color(fn ($state) => $state >= 4 ? 'success' : ($state ? 'danger' : 'gray'))
                    ->sortable(),

                TextColumn::make('feedback_comment')
                    ->label('Comment')
                    ->limit(30)
                    ->searchable()
                    ->wrap()
                    ->toggleable(),
                ])

                ->filters([
                SelectFilter::make('rating')
                ->options([
                    '5' => '5 Stars',
                    '4' => '4 Stars',
                    '3' => '3 Stars',
                    '2' => '2 Stars',
                    '1' => '1 Star',
                ]),
              
            ])
            ->actions([
                // 1. CLEANER SAYS: "I am driving there"
                Action::make('on_the_way')
                    ->label('On My Way')
                    ->icon('heroicon-m-truck')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record) => 
                        auth()->user()->role === 'cleaner' && $record->status === 'confirmed'
                    )
                    // Corrected: updates status to 'on_the_way'
                    ->action(fn (Booking $record) => $record->update(['status' => 'on_the_way'])),

                // 2. CLEANER SAYS: "I have arrived and started scrubbing"
                Action::make('start_cleaning')
                    ->label('Start Cleaning')
                    ->icon('heroicon-m-play')
                    ->color('primary')
                    ->visible(fn (Booking $record) => 
                        auth()->user()->role === 'cleaner' && $record->status === 'on_the_way'
                    )
                    ->action(fn (Booking $record) => $record->update(['status' => 'in_progress', 'started_at' => now()])),

                // 3. CLEANER SAYS: "I am done"
                Action::make('finish_cleaning')
                    ->label('Mark Finished')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Booking $record) => 
                        auth()->user()->role === 'cleaner' && $record->status === 'in_progress'
                    )
                    ->form([
                        FileUpload::make('after_photo')
                        ->label('Evidence of Transformation')
                        ->image()
                        ->imageEditor()
                        ->required()
                        ->helperText('Upload a photo showing the completed cleaning job. This helps maintain quality and transparency.'),
                    ])
                    ->action(function (Booking $record, array $data) {
                        $record->update([
                            'status' => 'completed',
                            'after_photo' => $data['after_photo'],
                            'completed_at' => now(),
                        ]);
                        Notification::make()->title('Sanctuary Completed!')->success()->send();
                    }),

                ViewAction::make(),
                EditAction::make()->visible(fn() => auth()->user()->role === 'admin'),

                Action::make('internal_chat')
                    ->label('Internal Chat')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('gray')
                    ->modalHeading('Booking Communication')
                    ->visible(fn()=>in_array(auth()->user()->role, ['admin','cleaner']))
                    ->form([
                        Textarea::make('message')
                        ->label('New Message')
                        ->placeholder('Type a note for the team...')
                        ->required(),
                    ])
                    ->action(function (Booking $record, array $data) {
                    // 1. Create the message
                    $newMessage = $record->messages()->create([
                        'user_id' => auth()->id(),
                        'message' => $data['message'],
                    ]);

                   // 2. Notify Admins if sender is a Cleaner
    if (auth()->user()->role === 'cleaner') {
        $admins = \App\Models\User::where('role', 'admin')->get();
        
        \Filament\Notifications\Notification::make()
            ->title('New Team Message')
            ->body(Str::limit($data['message'], 50))
            ->icon('heroicon-o-chat-bubble-left-right')
            ->color('success')
            ->actions([
                // We use the absolute path here to prevent collision with Table Actions
              Action::make('view')
                    ->label('View Chat')
                    ->button()
                    ->url(fn () => BookingResource::getUrl('view', ['record' => $record])),
            ])
            ->sendToDatabase($admins);
    }

    \Filament\Notifications\Notification::make()
        ->title('Message Sent')
        ->success()
        ->send();
})
            ])
            

         ->bulkActions([
    BulkActionGroup::make([
        DeleteBulkAction::make(),
        
        BulkAction::make('markAsCompleted')
            ->label('Mark as Completed')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (Collection $records) {
                // 1. Update the database
                $records->each->update(['status' => 'completed']);

                // 2. Send the toast notification to the UI
                Notification::make()
                    ->title('Bookings Updated')
                    ->body('The selected bookings have been marked as completed.')
                    ->success()
                    ->send();
            }),
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
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'view' => ViewBooking::route('/{record}'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }

public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
{
    $user = auth()->user();
    $query = parent::getEloquentQuery();

    if ($user->role === 'admin') {
        return $query;
    }

    if ($user->role === 'cleaner') {
        return $query->whereHas('cleaners', fn($q) => $q->where('user_id', $user->id));
    }

    // Forces customers to ONLY see their own email-matched bookings
    return $query->where('customer_email', $user->email);
}

public static function getNavigationBadge(): ?string
{
    $user = auth()->user();
    
    // Admins see total unread team messages
    if ($user->role === 'admin') {
        return BookingMessage::whereHas('booking')
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->count() ?: null;
    }

    return null;
}


  public static  function getNavigationBadgeColor(): ?string{
        return 'danger';
    }
}

