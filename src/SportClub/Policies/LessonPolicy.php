<?php

namespace Packages\Sports\SportClub\Policies;

use App\Models\Tenant\User;
use Packages\Sports\SportClub\Enums\LessonStatus;
use Packages\Sports\SportClub\Enums\ParticipantStatus;
use Packages\Sports\SportClub\Models\Lesson;

class LessonPolicy
{
    /**
     * View list of lessons (for navigation and list page)
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * View single lesson (for detail/edit page)
     */
    public function view(User $user, Lesson $lesson): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Create new lesson
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Update lesson
     */
    public function update(User $user, Lesson $lesson): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-lessons')) {
            return false;
        }

        // Business logic: Cannot modify completed lessons
        if ($lesson->status === LessonStatus::Completed) {
            return false;
        }

        return true;
    }

    /**
     * Delete lesson
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        // Permission check
        if (! $user->isAbleTo('manage-lessons')) {
            return false;
        }

        // Business logic: Cannot delete if has confirmed participants
        if ($lesson->lessonParticipants()->where('status', ParticipantStatus::Confirmed)->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Restore soft-deleted lesson
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        return $user->isAbleTo('manage-lessons');
    }

    /**
     * Permanently delete lesson
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        return $user->isAbleTo('manage-lessons');
    }
}
