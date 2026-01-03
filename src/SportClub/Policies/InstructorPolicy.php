<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\Instructor;

class InstructorPolicy
{
    /**
     * View list of instructors (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-instructors');
    }

    /**
     * View single instructor (for detail/edit page)
     */
    public function view(User $user, Instructor $instructor): bool
    {
        return $user->isAbleTo('manage-instructors');
    }

    /**
     * Create new instructor
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-instructors');
    }

    /**
     * Update instructor
     */
    public function update(User $user, Instructor $instructor): bool
    {
        return $user->isAbleTo('manage-instructors');
    }

    /**
     * Delete instructor
     */
    public function delete(User $user, Instructor $instructor): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-instructors')) {
            return false;
        }

        // Business logic: Cannot delete if has scheduled lessons
        if ($instructor->lessons()->whereIn('status', ['scheduled', 'in_progress'])->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted instructor
     */
    public function restore(User $user, Instructor $instructor): bool
    {
        return $user->isAbleTo('manage-instructors');
    }

    /**
     * Permanently delete instructor
     */
    public function forceDelete(User $user, Instructor $instructor): bool
    {
        return $user->isAbleTo('manage-instructors');
    }
}
