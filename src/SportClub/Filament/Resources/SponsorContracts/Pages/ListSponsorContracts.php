<?php

namespace Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\SponsorContractResource;

class ListSponsorContracts extends ListRecords
{
    protected static string $resource = SponsorContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
