<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Table;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
}
