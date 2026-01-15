<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sports\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Packages\Sports\SportClub\Filament\Resources\Sports\SportResource;
use Filament\Actions;

class EditSport extends EditRecord
{
    protected static string $resource = SportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
