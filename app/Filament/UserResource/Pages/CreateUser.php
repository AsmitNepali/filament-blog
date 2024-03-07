<?php

namespace App\Filament\UserResource\Pages;

use App\Filament\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
