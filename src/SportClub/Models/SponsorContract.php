<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SponsorContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'start_date',
        'end_date',
        'max_views',
        'used_views',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'max_views' => 'integer',
        'used_views' => 'integer',
    ];

    /**
     * Get the sponsor that owns the contract.
     */
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * Scope to get only active contracts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get contracts within a specific period.
     */
    public function scopeWithinPeriod($query, Carbon $date = null)
    {
        $date = $date ?? now();

        return $query->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date);
    }

    /**
     * Scope to get contracts that have available views.
     */
    public function scopeHasAvailableViews($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('max_views')
                ->orWhereColumn('used_views', '<', 'max_views');
        });
    }

    /**
     * Check if the contract is currently valid.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($now->lt($this->start_date) || $now->gt($this->end_date)) {
            return false;
        }

        if ($this->max_views !== null && $this->used_views >= $this->max_views) {
            return false;
        }

        return true;
    }

    /**
     * Increment the view counter.
     */
    public function incrementViews(): void
    {
        $this->increment('used_views');
    }

    /**
     * Decrement the view counter (e.g., if a view was removed).
     */
    public function decrementViews(): void
    {
        if ($this->used_views > 0) {
            $this->decrement('used_views');
        }
    }

    /**
     * Get the remaining views available.
     */
    public function remainingViews(): ?int
    {
        if ($this->max_views === null) {
            return null; // Unlimited
        }

        return max(0, $this->max_views - $this->used_views);
    }
}
