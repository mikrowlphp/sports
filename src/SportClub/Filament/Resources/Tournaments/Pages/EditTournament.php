<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\TournamentResource;

class EditTournament extends EditRecord
{
    protected static string $resource = TournamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
