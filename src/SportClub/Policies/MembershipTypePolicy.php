<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\MembershipType;

class MembershipTypePolicy
{
    /**
     * View list of membership types (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-membership-types');
    }

    /**
     * View single membership type (for detail/edit page)
     */
    public function view(User $user, MembershipType $membershipType): bool
    {
        return $user->isAbleTo('manage-membership-types');
    }

    /**
     * Create new membership type
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-membership-types');
    }

    /**
     * Update membership type
     */
    public function update(User $user, MembershipType $membershipType): bool
    {
        return $user->isAbleTo('manage-membership-types');
    }

    /**
     * Delete membership type
     */
    public function delete(User $user, MembershipType $membershipType): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-membership-types')) {
            return false;
        }

        // Business logic: Cannot delete if has active subscriptions
        if ($membershipType->subscriptions()->whereIn('status', ['active', 'pending'])->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted membership type
     */
    public function restore(User $user, MembershipType $membershipType): bool
    {
        return $user->isAbleTo('manage-membership-types');
    }

    /**
     * Permanently delete membership type
     */
    public function forceDelete(User $user, MembershipType $membershipType): bool
    {
        return $user->isAbleTo('manage-membership-types');
    }
}
