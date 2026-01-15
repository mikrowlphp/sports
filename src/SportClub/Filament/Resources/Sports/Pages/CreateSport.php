<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sports\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Sports\SportResource;

class CreateSport extends CreateRecord
{
    protected static string $resource = SportResource::class;
}
