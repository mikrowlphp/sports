<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\MembershipTypeResource;

class EditMembershipType extends EditRecord
{
    protected static string $resource = MembershipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
