<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum TournamentStatus: string implements HasLabel
{
    case Draft = 'draft';
    case RegistrationOpen = 'registration_open';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return __('sports::enums.tournament_status.' . $this->value);
    }
}
