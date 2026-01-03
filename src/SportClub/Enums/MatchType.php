<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum MatchType: string implements HasLabel
{
    case Team = 'team';
    case Individual = 'individual';

    public function getLabel(): string
    {
        return match ($this) {
            self::Team => __('sports::matches.team_match'),
            self::Individual => __('sports::matches.individual_match'),
        };
    }
}
