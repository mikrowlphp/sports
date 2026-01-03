<?php

namespace Packages\Sports\SportClub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\SubscriptionStatus;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'membership_type_id',
        'start_date',
        'end_date',
        'status',
        'amount_paid',
        'payment_reference',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => SubscriptionStatus::class,
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Get the customer (contact) that owns the subscription.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    /**
     * Get the membership type for this subscription.
     */
    public function membershipType(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class);
    }

    /**
     * Scope active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', SubscriptionStatus::Active);
    }

    /**
     * Scope expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', SubscriptionStatus::Expired);
    }
}
