<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\MatchResult;

class MatchResultPolicy
{
    /**
     * View list of match results (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * View single match result (for detail/edit page)
     */
    public function view(User $user, MatchResult $matchResult): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Create new match result
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Update match result
     */
    public function update(User $user, MatchResult $matchResult): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Delete match result
     */
    public function delete(User $user, MatchResult $matchResult): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Restore soft-deleted match result
     */
    public function restore(User $user, MatchResult $matchResult): bool
    {
        return $user->isAbleTo('manage-matches');
    }

    /**
     * Permanently delete match result
     */
    public function forceDelete(User $user, MatchResult $matchResult): bool
    {
        return $user->isAbleTo('manage-matches');
    }
}
