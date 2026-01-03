<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Matches\MatchResource;

class CreateMatch extends CreateRecord
{
    protected static string $resource = MatchResource::class;
}
