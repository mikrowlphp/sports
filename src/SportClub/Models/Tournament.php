<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Packages\Sports\SportClub\Models\Team;
use Packages\Sports\SportClub\Enums\TournamentFormat;
use Packages\Sports\SportClub\Enums\TournamentStatus;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sport',
        'description',
        'start_date',
        'end_date',
        'format',
        'status',
        'max_teams',
        'entry_fee',
        'prize',
        'rules',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'format' => TournamentFormat::class,
        'status' => TournamentStatus::class,
        'max_teams' => 'integer',
        'entry_fee' => 'decimal:2',
    ];

    /**
     * Get all rounds for this tournament.
     */
    public function rounds(): HasMany
    {
        return $this->hasMany(TournamentRound::class);
    }

    /**
     * Get all tournament team entries (pivot records).
     */
    public function tournamentTeams(): HasMany
    {
        return $this->hasMany(TournamentTeam::class);
    }

    /**
     * Get all teams participating in this tournament.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'tournament_teams')
            ->using(TournamentTeam::class)
            ->withPivot(['seed', 'status', 'registration_date'])
            ->withTimestamps();
    }

    /**
     * Scope upcoming tournaments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())->orderBy('start_date');
    }

    /**
     * Scope active tournaments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', TournamentStatus::InProgress);
    }
}
