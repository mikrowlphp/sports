<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\TournamentResource;

class ListTournaments extends ListRecords
{
    protected static string $resource = TournamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
