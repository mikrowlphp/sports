<?php

namespace Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\SponsorContractResource;

class CreateSponsorContract extends CreateRecord
{
    protected static string $resource = SponsorContractResource::class;
}
