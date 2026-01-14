<?php

use Illuminate\Support\Facades\Route;
use Packages\Sports\SportClub\Models\SportMatch;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/match/{matchId}/player', function (int $matchId) {
        $match = SportMatch::findOrFail($matchId);
        return view('sports::pages.match-player', ['match' => $match]);
    })->name('sports.match.player');

    Route::get('/match/{matchId}/viewer', function (int $matchId) {
        $match = SportMatch::findOrFail($matchId);
        return view('sports::pages.match-viewer', ['match' => $match]);
    })->name('sports.match.viewer');
});
