<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\Field;

class FieldPolicy
{
    /**
     * View list of fields (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-fields');
    }

    /**
     * View single field (for detail/edit page)
     */
    public function view(User $user, Field $field): bool
    {
        return $user->isAbleTo('manage-fields');
    }

    /**
     * Create new field
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-fields');
    }

    /**
     * Update field
     */
    public function update(User $user, Field $field): bool
    {
        return $user->isAbleTo('manage-fields');
    }

    /**
     * Delete field
     */
    public function delete(User $user, Field $field): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-fields')) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted field
     */
    public function restore(User $user, Field $field): bool
    {
        return $user->isAbleTo('manage-fields');
    }

    /**
     * Permanently delete field
     */
    public function forceDelete(User $user, Field $field): bool
    {
        return $user->isAbleTo('manage-fields');
    }
}
