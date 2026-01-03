<?php

namespace Packages\Sports\SportClub\Enums;

enum TournamentTeamStatus: string
{
    case Registered = 'registered';
    case Confirmed = 'confirmed';
    case Withdrawn = 'withdrawn';
    case Eliminated = 'eliminated';
    case Winner = 'winner';
}
