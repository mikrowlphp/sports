<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\Teams\TeamResource;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
