<?php

namespace Packages\Sports\SportClub\Models;

use App\Models\ObservableModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\LessonStatus;
use Packages\Sports\SportClub\Enums\LessonType;
use Packages\Sports\SportClub\Models\Sport;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'lesson_type',
        'sport_id',
        'scheduled_at',
        'duration_minutes',
        'max_participants',
        'price_per_person',
        'location',
        'status',
        'notes',
    ];

    protected $casts = [
        'lesson_type' => LessonType::class,
        'scheduled_at' => 'datetime',
        'duration_minutes' => 'integer',
        'max_participants' => 'integer',
        'price_per_person' => 'decimal:2',
        'status' => LessonStatus::class,
    ];

    /**
     * Get the instructor for this lesson.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Get the sport for this lesson.
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get all lesson participants (pivot records).
     */
    public function lessonParticipants(): HasMany
    {
        return $this->hasMany(LessonParticipant::class);
    }

    /**
     * Get all participants (contacts/customers) for this lesson.
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'lesson_participants', 'lesson_id', 'customer_id')
            ->using(LessonParticipant::class)
            ->withPivot(['status', 'payment_status', 'amount_paid', 'notes'])
            ->withTimestamps();
    }

    /**
     * Scope scheduled lessons.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', LessonStatus::Scheduled);
    }

    /**
     * Scope upcoming lessons.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())->orderBy('scheduled_at');
    }
}
