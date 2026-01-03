<?php

namespace Packages\Sports\SportClub\Enums;

enum MatchStatus: string
{
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Postponed = 'postponed';
    case Cancelled = 'cancelled';
}
