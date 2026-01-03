<?php

namespace Packages\Sports\SportClub\Enums;

enum TournamentStatus: string
{
    case Draft = 'draft';
    case RegistrationOpen = 'registration_open';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
