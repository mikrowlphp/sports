<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ObservableModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ulid',
        'name',
        'logo',
        'url',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    /**
     * Get all contracts for this sponsor.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(SponsorContract::class);
    }

    /**
     * Get all match placements for this sponsor.
     */
    public function placements(): HasMany
    {
        return $this->hasMany(MatchSponsorPlacement::class);
    }

    /**
     * Get all matches where this sponsor is placed.
     */
    public function matches(): BelongsToMany
    {
        return $this->belongsToMany(SportMatch::class, 'match_sponsor_placements', 'sponsor_id', 'match_id')
            ->withPivot('position')
            ->withTimestamps();
    }

    /**
     * Scope to get only active sponsors.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
