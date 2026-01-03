<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\WinnerType;
use Packages\Sports\SportClub\Models\Team;

class MatchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'home_score',
        'away_score',
        'winner_type',
        'winner_team_id',
        'winner_player_id',
        'duration_minutes',
        'statistics',
        'notes',
        'recorded_at',
    ];

    protected $casts = [
        'home_score' => 'integer',
        'away_score' => 'integer',
        'winner_type' => WinnerType::class,
        'duration_minutes' => 'integer',
        'statistics' => 'array',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the match this result belongs to.
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(SportMatch::class);
    }

    /**
     * Get the winning team.
     */
    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    /**
     * Get the winning player (for individual sports).
     */
    public function winnerPlayer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'winner_player_id');
    }
}
