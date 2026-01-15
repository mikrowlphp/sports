<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Fields\FieldResource;

class CreateField extends CreateRecord
{
    protected static string $resource = FieldResource::class;
}
