<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\Team;

class TeamPolicy
{
    /**
     * View list of teams (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * View single team (for detail/edit page)
     */
    public function view(User $user, Team $team): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Create new team
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Update team
     */
    public function update(User $user, Team $team): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Delete team
     */
    public function delete(User $user, Team $team): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-teams')) {
            return false;
        }

        // Business logic: Cannot delete if has active tournament registrations
        if ($team->tournamentTeams()->whereHas('tournament', function ($query) {
            $query->whereIn('status', ['planning', 'in_progress']);
        })->exists()) {
            return false;
        }

        // Business logic: Cannot delete if has active matches
        if ($team->homeMatches()->whereIn('status', ['scheduled', 'in_progress'])->exists() ||
            $team->awayMatches()->whereIn('status', ['scheduled', 'in_progress'])->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted team
     */
    public function restore(User $user, Team $team): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Permanently delete team
     */
    public function forceDelete(User $user, Team $team): bool
    {
        return $user->isAbleTo('manage-teams');
    }
}
