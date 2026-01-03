<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\ParticipantStatus;
use Packages\Sports\SportClub\Enums\PaymentStatus;

class LessonParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'customer_id',
        'status',
        'payment_status',
        'amount_paid',
        'notes',
    ];

    protected $casts = [
        'status' => ParticipantStatus::class,
        'payment_status' => PaymentStatus::class,
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Get the lesson this participant is enrolled in.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the customer (contact) for this participant.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Scope confirmed participants.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', ParticipantStatus::Confirmed);
    }

    /**
     * Scope paid participants.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', PaymentStatus::Paid);
    }
}
