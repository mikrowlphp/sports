<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\Instructors\InstructorResource;

class EditInstructor extends EditRecord
{
    protected static string $resource = InstructorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
