<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\Matches\MatchResource;

class EditMatch extends EditRecord
{
    protected static string $resource = MatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
