<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\Matches\MatchResource;

class ListMatches extends ListRecords
{
    protected static string $resource = MatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
