<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\MembershipTypeResource;

class ListMembershipTypes extends ListRecords
{
    protected static string $resource = MembershipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
