<?php

namespace Packages\Sports\SportClub\Enums;

enum ParticipantStatus: string
{
    case Registered = 'registered';
    case Confirmed = 'confirmed';
    case Attended = 'attended';
    case NoShow = 'no_show';
    case Cancelled = 'cancelled';
}
