<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Packages\Sports\SportClub\Filament\Resources\Fields\FieldResource;
use Filament\Actions;

class ListFields extends ListRecords
{
    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
