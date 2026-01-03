<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\TournamentRound;

class TournamentRoundPolicy
{
    /**
     * View list of tournament rounds (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * View single tournament round (for detail/edit page)
     */
    public function view(User $user, TournamentRound $tournamentRound): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Create new tournament round
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Update tournament round
     */
    public function update(User $user, TournamentRound $tournamentRound): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Delete tournament round
     */
    public function delete(User $user, TournamentRound $tournamentRound): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Restore soft-deleted tournament round
     */
    public function restore(User $user, TournamentRound $tournamentRound): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }

    /**
     * Permanently delete tournament round
     */
    public function forceDelete(User $user, TournamentRound $tournamentRound): bool
    {
        return $user->isAbleTo('manage-tournaments');
    }
}
