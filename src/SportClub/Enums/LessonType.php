<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum LessonType: string implements HasLabel
{
    case Individual = 'individual';
    case Group = 'group';
    case Course = 'course';

    public function getLabel(): string
    {
        return __('sports::enums.lesson_type.' . $this->value);
    }
}
