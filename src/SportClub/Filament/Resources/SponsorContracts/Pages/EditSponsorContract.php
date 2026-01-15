<?php

namespace Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\SponsorContractResource;

class EditSponsorContract extends EditRecord
{
    protected static string $resource = SponsorContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
