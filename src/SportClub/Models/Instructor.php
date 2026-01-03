<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Packages\Core\Contacts\Models\Contact;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'specializations',
        'bio',
        'hourly_rate',
        'is_active',
    ];

    protected $casts = [
        'specializations' => 'array',
        'hourly_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the customer (contact) for this instructor.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Get all lessons taught by this instructor.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Scope active instructors.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
