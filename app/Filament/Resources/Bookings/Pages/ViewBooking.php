<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function afterFill(){
        $this->record->messages()
        ->where('user_id','!=',  auth()->id())
        ->whereNull('read_at')
        ->update(['read_at'=>now()]);
    }
}
