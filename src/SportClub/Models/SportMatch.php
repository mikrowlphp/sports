<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ObservableModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\MatchStatus;
use Packages\Sports\SportClub\Enums\MatchType;
use Packages\Sports\SportClub\Models\Team;
use Packages\Sports\SportClub\Models\Tournament;
use Packages\Sports\SportClub\Models\TournamentRound;

class SportMatch extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = [
        'name',
        'tournament_id',
        'round_id',
        'home_team_id',
        'away_team_id',
        'home_player_id',
        'away_player_id',
        'scheduled_at',
        'court',
        'match_type',
        'status',
        'notes',
        'video_url',
        'recording_enabled',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'match_type' => MatchType::class,
        'status' => MatchStatus::class,
        'recording_enabled' => 'boolean',
    ];

    /**
     * Get the tournament this match belongs to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get the tournament round this match belongs to.
     */
    public function round(): BelongsTo
    {
        return $this->belongsTo(TournamentRound::class, 'round_id');
    }

    /**
     * Get the home team.
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team.
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Get the home player (for individual sports).
     */
    public function homePlayer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'home_player_id');
    }

    /**
     * Get the away player (for individual sports).
     */
    public function awayPlayer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'away_player_id');
    }

    /**
     * Get the match result.
     */
    public function result(): HasOne
    {
        return $this->hasOne(MatchResult::class, 'match_id');
    }

    /**
     * Scope scheduled matches.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', MatchStatus::Scheduled);
    }

    /**
     * Scope upcoming matches.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())->orderBy('scheduled_at');
    }

    /**
     * Get all sponsor placements for this match.
     */
    public function sponsorPlacements(): HasMany
    {
        return $this->hasMany(MatchSponsorPlacement::class, 'match_id');
    }

    /**
     * Get all sponsors for this match.
     */
    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'match_sponsor_placements', 'match_id', 'sponsor_id')
            ->withPivot('position')
            ->withTimestamps();
    }
}
