<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sports\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Packages\Sports\SportClub\Filament\Resources\Sports\SportResource;
use Filament\Actions;

class ListSports extends ListRecords
{
    protected static string $resource = SportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
