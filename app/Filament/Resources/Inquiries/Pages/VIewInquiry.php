<?php
namespace App\Filament\Resources\InquiryResource\Pages; // <--- Double check this path

use App\Filament\Resources\Inquiries\InquiryResource;
use App\Mail\AdminInquiryResponse;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification; // Ensure this is imported
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewInquiry extends ViewRecord
{
    protected static string $resource = InquiryResource::class; // <--- Required

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->form([
                    Textarea::make('reply_message')
                        ->label('Your Response')
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    // Save response
                    $record->responses()->create([
                        'message' => $data['reply_message'],
                        'admin_name' => auth()->user()->name,
                    ]);

                    // Send Email
                    Mail::to($record->email)->send(new AdminInquiryResponse($record, $data['reply_message']));

                    // Mark as read
                    $record->update(['is_read' => true]);

                    Notification::make()
                        ->title('Reply Sent')
                        ->success()
                        ->send();
                }),
            
            DeleteAction::make(),
        ];
    }
}