<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ObservableModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Sports\SportClub\Enums\SponsorPosition;

class MatchSponsorPlacement extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'sponsor_id',
        'position',
    ];

    protected $casts = [
        'position' => SponsorPosition::class,
    ];

    /**
     * Get the match this placement belongs to.
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(SportMatch::class, 'match_id');
    }

    /**
     * Get the sponsor for this placement.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
}
