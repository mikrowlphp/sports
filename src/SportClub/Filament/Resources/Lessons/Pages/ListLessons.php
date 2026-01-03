<?php

namespace Packages\Sports\SportClub\Filament\Resources\Lessons\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\Lessons\LessonResource;

class ListLessons extends ListRecords
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
