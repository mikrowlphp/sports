<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\Instructors\InstructorResource;

class ListInstructors extends ListRecords
{
    protected static string $resource = InstructorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
