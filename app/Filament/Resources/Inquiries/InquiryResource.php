<?php

namespace App\Filament\Resources\Inquiries;

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Inquiries\Schemas\InquiryForm;
use App\Filament\Resources\Inquiries\Tables\InquiriesTable;
use App\Filament\Resources\InquiryResource\Pages\ViewInquiry;
use App\Mail\AdminInquiryResponse;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'inquiry';

    //protected static ?string $navigationIcon ='heroincon-o-chat-bubble-left-right'

    public static function form(Schema $schema): Schema
    {
       return $schema
            ->components([
                Section::make('Original Inquiry')
                ->schema([
                    TextInput::make('full_name')->disabled(),
                    TextInput::make('email')->disabled(),
                    Textarea::make('message')->disabled()->columnSpanFull(),

                ])->columns(2),
                Section::make('Comunication Thread')
                ->schema([
                    Placeholder::make('thread')
                    ->label('')
                    ->content(fn ($record) => view('filament.components.inquiry-thread', ['record' => $record])),
                ])
            ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('full_name')->searchable(),
            TextColumn::make('email'),
            IconColumn::make('is_read')->boolean()
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
    ->trueColor('success')
    ->falseColor('danger'),
            TextColumn::make('created_at')->dateTime()->label('Received'),
           
        ])
        ->actions([
            Action::make('reply')
    ->icon('heroicon-o-envelope')
    ->color('success')
    ->modalHeading(fn ($record) => "Reply to {$record->full_name}")
    ->form([
        Textarea::make('reply_message')
            ->label('Your Response')
            ->required()
            ->rows(5),
    ])
    ->action(function ($record, array $data) {
        $record->responses()->create([
         'message'=>$data['reply_message'],
         'admin_name'=>auth()->user()->name,
        ]);
        $content = $data['reply_message'];
        // 1. Send the Email
        Mail::to($record->email)->send(new AdminInquiryResponse($record, $content));

        // 2. Mark as read
        $record->update(['is_read' => true]);

        // 3. Notify Admin of success
        Notification::make()
            ->title('Reply Sent')
            ->success()
            ->send();
    }),
          ViewAction::make(), 
          DeleteAction::make(),
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
            'index' => ListInquiries::route('/'),
            'create' => CreateInquiry::route('/create'),
            'view' => ViewInquiry::route('/{record}'),
            'edit' => EditInquiry::route('/{record}/edit'),
        ];
    }

         public static function getNavigationBadge(): ?string {
        return static::getModel()::where('is_read',false)->count() ?:null;
    }

    public static function canViewAny(): bool
    {
        // Hides the "Users" link from the sidebar for non-admins
        return auth()->user()?->role === 'admin';
    }

    public static function canCreate(): bool{
        return false;
    }
}

