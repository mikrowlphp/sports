<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Enums\PaymentStatus;
use Packages\Sports\SportClub\Models\LessonParticipant;

class LessonParticipantPolicy
{
    /**
     * View list of lesson participants (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * View single lesson participant (for detail/edit page)
     */
    public function view(User $user, LessonParticipant $lessonParticipant): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Create new lesson participant
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Update lesson participant
     */
    public function update(User $user, LessonParticipant $lessonParticipant): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Delete lesson participant
     */
    public function delete(User $user, LessonParticipant $lessonParticipant): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-lessons')) {
            return false;
        }

        // Business logic: Cannot delete paid participants without refund
        // This would require manual refund processing first
        if ($lessonParticipant->payment_status === PaymentStatus::Paid) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted lesson participant
     */
    public function restore(User $user, LessonParticipant $lessonParticipant): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Permanently delete lesson participant
     */
    public function forceDelete(User $user, LessonParticipant $lessonParticipant): bool
    {
        return $user->isAbleTo('manage-lessons');
    }
}
