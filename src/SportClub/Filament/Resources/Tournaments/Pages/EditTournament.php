<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Enums\TournamentStatus;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\TournamentResource;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\Widgets\TournamentToolbar;

class EditTournament extends EditRecord
{
    protected static string $resource = TournamentResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            TournamentToolbar::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn () => $this->record->status === TournamentStatus::Draft),
        ];
    }
}
