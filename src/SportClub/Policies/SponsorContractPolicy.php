<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Models\SponsorContract;

class SponsorContractPolicy
{
    /**
     * View list of sponsor contracts (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }

    /**
     * View single sponsor contract (for detail/edit page)
     */
    public function view(User $user, SponsorContract $sponsorContract): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }

    /**
     * Create new sponsor contract
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }

    /**
     * Update sponsor contract
     */
    public function update(User $user, SponsorContract $sponsorContract): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }

    /**
     * Delete sponsor contract
     */
    public function delete(User $user, SponsorContract $sponsorContract): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }

    /**
     * Restore soft-deleted sponsor contract
     */
    public function restore(User $user, SponsorContract $sponsorContract): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }

    /**
     * Permanently delete sponsor contract
     */
    public function forceDelete(User $user, SponsorContract $sponsorContract): bool
    {
        return $user->isAbleTo('manage-sponsors');
    }
}
