<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\TournamentResource;

class CreateTournament extends CreateRecord
{
    protected static string $resource = TournamentResource::class;
}
