<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Enums\MatchStatus;
use Packages\Sports\SportClub\Models\SportMatch;

class MatchPolicy
{
    /**
     * View list of matches (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * View single match (for detail/edit page)
     */
    public function view(User $user, SportMatch $match): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Create new match
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Update match
     */
    public function update(User $user, SportMatch $match): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-matches')) {
            return false;
        }

        // Business logic: Cannot modify completed matches
        if ($match->status === MatchStatus::Completed) {
            return false;
        }

        return true;
    }

    /**
     * Delete match
     */
    public function delete(User $user, SportMatch $match): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-matches')) {
            return false;
        }

        // Business logic: Cannot delete matches with results
        if ($match->result()->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted match
     */
    public function restore(User $user, SportMatch $match): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Permanently delete match
     */
    public function forceDelete(User $user, SportMatch $match): bool
    {
        return $user->isAbleTo('manage-matches');
    }
}
