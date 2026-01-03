<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\MembershipTypeResource;

class CreateMembershipType extends CreateRecord
{
    protected static string $resource = MembershipTypeResource::class;
}
