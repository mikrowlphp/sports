<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum TeamMemberRole: string implements HasLabel
{
    case Player = 'player';
    case Captain = 'captain';
    case Coach = 'coach';
    case Manager = 'manager';

    public function getLabel(): string
    {
        return __('sports::enums.team_member_role.' . $this->value);
    }
}
