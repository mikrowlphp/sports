<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\TournamentTeam;

class TournamentTeamPolicy
{
    /**
     * View list of tournament teams (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * View single tournament team (for detail/edit page)
     */
    public function view(User $user, TournamentTeam $tournamentTeam): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Create new tournament team
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Update tournament team
     */
    public function update(User $user, TournamentTeam $tournamentTeam): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Delete tournament team
     */
    public function delete(User $user, TournamentTeam $tournamentTeam): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Restore soft-deleted tournament team
     */
    public function restore(User $user, TournamentTeam $tournamentTeam): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Permanently delete tournament team
     */
    public function forceDelete(User $user, TournamentTeam $tournamentTeam): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }
}
