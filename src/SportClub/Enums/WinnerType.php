<?php

namespace Packages\Sports\SportClub\Enums;

enum WinnerType: string
{
    case Home = 'home';
    case Away = 'away';
    case Draw = 'draw';
}
