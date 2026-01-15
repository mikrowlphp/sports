<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum TournamentTeamStatus: string implements HasLabel
{
    case Registered = 'registered';
    case Confirmed = 'confirmed';
    case Withdrawn = 'withdrawn';
    case Eliminated = 'eliminated';
    case Winner = 'winner';

    public function getLabel(): string
    {
        return __('sports::enums.tournament_team_status.' . $this->value);
    }
}
