<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum WinnerType: string implements HasLabel
{
    case Home = 'home';
    case Away = 'away';
    case Draw = 'draw';

    public function getLabel(): string
    {
        return __('sports::enums.winner_type.' . $this->value);
    }
}
