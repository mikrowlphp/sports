<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sponsors\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Sponsors\SponsorResource;

class CreateSponsor extends CreateRecord
{
    protected static string $resource = SponsorResource::class;
}
