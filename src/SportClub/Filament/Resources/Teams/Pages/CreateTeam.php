<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Teams\TeamResource;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;
}
