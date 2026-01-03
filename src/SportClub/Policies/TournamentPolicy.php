<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Enums\TournamentStatus;
use Packages\Sports\SportClub\Models\Tournament;

class TournamentPolicy
{
    /**
     * View list of tournaments (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * View single tournament (for detail/edit page)
     */
    public function view(User $user, Tournament $tournament): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Create new tournament
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Update tournament
     */
    public function update(User $user, Tournament $tournament): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-tournaments')) {
            return false;
        }

        // Business logic: Cannot modify completed tournaments
        if ($tournament->status === TournamentStatus::Completed) {
            return false;
        }

        return true;
    }

    /**
     * Delete tournament
     */
    public function delete(User $user, Tournament $tournament): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-tournaments')) {
            return false;
        }

        // Business logic: Cannot delete if has matches played
        if ($tournament->matches()->whereIn('status', ['completed', 'in_progress'])->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted tournament
     */
    public function restore(User $user, Tournament $tournament): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Permanently delete tournament
     */
    public function forceDelete(User $user, Tournament $tournament): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }
}
