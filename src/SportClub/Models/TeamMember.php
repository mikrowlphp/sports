<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\TeamMemberRole;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'customer_id',
        'role',
        'jersey_number',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'role' => TeamMemberRole::class,
        'jersey_number' => 'integer',
        'joined_at' => 'date',
        'left_at' => 'date',
    ];

    /**
     * Get the team this member belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the customer (contact) for this team member.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Scope active members (not left).
     */
    public function scopeActive($query)
    {
        return $query->whereNull('left_at');
    }

    /**
     * Scope members by role.
     */
    public function scopeByRole($query, TeamMemberRole $role)
    {
        return $query->where('role', $role);
    }
}
