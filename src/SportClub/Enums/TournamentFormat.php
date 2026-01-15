<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum TournamentFormat: string implements HasLabel
{
    case SingleElimination = 'single_elimination';
    case DoubleElimination = 'double_elimination';
    case RoundRobin = 'round_robin';
    case League = 'league';

    public function getLabel(): string
    {
        return __('sports::enums.tournament_format.' . $this->value);
    }
}
