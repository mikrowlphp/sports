<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ObservableModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Models\Sport;
use Packages\Sports\SportClub\Models\SportMatch;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sport_id',
        'category',
        'level',
        'max_members',
        'is_active',
        'logo',
    ];

    protected $casts = [
        'max_members' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the sport this team belongs to.
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get all team members (pivot records with extra data).
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * Get all contacts (customers) that are members of this team.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'team_members', 'team_id', 'customer_id')
            ->using(TeamMember::class)
            ->withPivot(['role', 'jersey_number', 'joined_at', 'left_at'])
            ->withTimestamps();
    }

    /**
     * Scope active teams.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope teams by sport.
     */
    public function scopeBySport($query, int $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    /**
     * Get all matches where this team is the home team.
     */
    public function homeMatches(): HasMany
    {
        return $this->hasMany(SportMatch::class, 'home_team_id');
    }

    /**
     * Get all matches where this team is the away team.
     */
    public function awayMatches(): HasMany
    {
        return $this->hasMany(SportMatch::class, 'away_team_id');
    }
}
