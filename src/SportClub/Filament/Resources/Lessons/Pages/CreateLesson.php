<?php

namespace Packages\Sports\SportClub\Filament\Resources\Lessons\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Lessons\LessonResource;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;
}
