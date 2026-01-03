<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Sports\SportClub\Models\Team;
use Packages\Sports\SportClub\Enums\TournamentTeamStatus;

class TournamentTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'team_id',
        'seed',
        'status',
        'registration_date',
    ];

    protected $casts = [
        'seed' => 'integer',
        'status' => TournamentTeamStatus::class,
        'registration_date' => 'datetime',
    ];

    /**
     * Get the tournament this entry belongs to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get the team for this tournament entry.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Scope registered teams.
     */
    public function scopeRegistered($query)
    {
        return $query->where('status', TournamentTeamStatus::Registered);
    }

    /**
     * Scope confirmed teams.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', TournamentTeamStatus::Confirmed);
    }
}
