<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentRound extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'name',
        'round_number',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'round_number' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the tournament this round belongs to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
