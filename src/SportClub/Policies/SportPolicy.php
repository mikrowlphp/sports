<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\Sport;

class SportPolicy
{
    /**
     * View list of sports (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-sports');
    }

    /**
     * View single sport (for detail/edit page)
     */
    public function view(User $user, Sport $sport): bool
    {
        return $user->isAbleTo('manage-sports');
    }

    /**
     * Create new sport
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-sports');
    }

    /**
     * Update sport
     */
    public function update(User $user, Sport $sport): bool
    {
        return $user->isAbleTo('manage-sports');
    }

    /**
     * Delete sport
     */
    public function delete(User $user, Sport $sport): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-sports')) {
            return false;
        }

        // Business logic: Cannot delete if has associated fields
        if ($sport->fields()->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted sport
     */
    public function restore(User $user, Sport $sport): bool
    {
        return $user->isAbleTo('manage-sports');
    }

    /**
     * Permanently delete sport
     */
    public function forceDelete(User $user, Sport $sport): bool
    {
        return $user->isAbleTo('manage-sports');
    }
}
