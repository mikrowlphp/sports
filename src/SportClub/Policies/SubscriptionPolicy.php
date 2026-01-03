<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Enums\SubscriptionStatus;
use Packages\Sports\SportClub\Models\Subscription;

class SubscriptionPolicy
{
    /**
     * View list of subscriptions (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-subscriptions');
    }

    /**
     * View single subscription (for detail/edit page)
     */
    public function view(User $user, Subscription $subscription): bool
    {
        return $user->isAbleTo('manage-subscriptions');
    }

    /**
     * Create new subscription
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-subscriptions');
    }

    /**
     * Update subscription
     */
    public function update(User $user, Subscription $subscription): bool
    {
        return $user->isAbleTo('manage-subscriptions');
    }

    /**
     * Delete subscription
     */
    public function delete(User $user, Subscription $subscription): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-subscriptions')) {
            return false;
        }

        // Business logic: Cannot delete active subscriptions
        if ($subscription->status === SubscriptionStatus::Active) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted subscription
     */
    public function restore(User $user, Subscription $subscription): bool
    {
        return $user->isAbleTo('manage-subscriptions');
    }

    /**
     * Permanently delete subscription
     */
    public function forceDelete(User $user, Subscription $subscription): bool
    {
        return $user->isAbleTo('manage-subscriptions');
    }
}
