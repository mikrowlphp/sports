<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum ParticipantStatus: string implements HasLabel
{
    case Registered = 'registered';
    case Confirmed = 'confirmed';
    case Attended = 'attended';
    case NoShow = 'no_show';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return __('sports::enums.participant_status.' . $this->value);
    }
}
