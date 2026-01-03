<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Instructors\InstructorResource;

class CreateInstructor extends CreateRecord
{
    protected static string $resource = InstructorResource::class;
}
