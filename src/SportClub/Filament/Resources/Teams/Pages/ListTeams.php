<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\Teams\TeamResource;

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
