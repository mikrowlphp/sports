<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\TeamMember;

class TeamMemberPolicy
{
    /**
     * View list of team members (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * View single team member (for detail/edit page)
     */
    public function view(User $user, TeamMember $teamMember): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Create new team member
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Update team member
     */
    public function update(User $user, TeamMember $teamMember): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Delete team member
     */
    public function delete(User $user, TeamMember $teamMember): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Restore soft-deleted team member
     */
    public function restore(User $user, TeamMember $teamMember): bool
    {
        return $user->isAbleTo('manage-teams');
    }

    /**
     * Permanently delete team member
     */
    public function forceDelete(User $user, TeamMember $teamMember): bool
    {
        return $user->isAbleTo('manage-teams');
    }
}
