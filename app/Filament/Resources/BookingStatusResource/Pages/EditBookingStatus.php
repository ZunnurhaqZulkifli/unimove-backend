<?php

namespace App\Filament\Resources\BookingStatusResource\Pages;

use App\Filament\Resources\BookingStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingStatus extends EditRecord
{
    protected static string $resource = BookingStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
