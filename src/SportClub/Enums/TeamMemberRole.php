<?php

namespace Packages\Sports\SportClub\Enums;

enum TeamMemberRole: string
{
    case Player = 'player';
    case Captain = 'captain';
    case Coach = 'coach';
    case Manager = 'manager';
}
