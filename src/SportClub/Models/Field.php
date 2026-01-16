<?php

namespace Packages\Sports\SportClub\Models;

use App\Models\ObservableModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'sport_id',
        'name',
        'description',
        'capacity',
        'hourly_rate',
        'color',
        'is_indoor',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'hourly_rate' => 'decimal:2',
        'is_indoor' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the sport this field belongs to.
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Scope active fields.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope indoor fields.
     */
    public function scopeIndoor($query)
    {
        return $query->where('is_indoor', true);
    }

    /**
     * Scope outdoor fields.
     */
    public function scopeOutdoor($query)
    {
        return $query->where('is_indoor', false);
    }

    /**
     * Scope fields by sport.
     */
    public function scopeBySport($query, int $sportId)
    {
        return $query->where('sport_id', $sportId);
    }

    /**
     * Scope fields ordered by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
