<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Models\SportMatch;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sport',
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
    public function scopeBySport($query, string $sport)
    {
        return $query->where('sport', $sport);
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
