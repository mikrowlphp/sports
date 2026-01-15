<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Packages\Sports\SportClub\Filament\Resources\Fields\FieldResource;
use Filament\Actions;

class EditField extends EditRecord
{
    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
