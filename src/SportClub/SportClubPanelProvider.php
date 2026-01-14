<?php

namespace Packages\Sports\SportClub;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class SportClubPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('sport-club')
            ->path('mikrowl/sport-club')
           ->discoverForPackage('sports', 'sport-club')
            ->tenantPanel();
    }
}
