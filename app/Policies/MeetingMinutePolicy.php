<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\MeetingMinute;
use App\Models\User;
use App\Policies\Traits\HasAdminPrivileges;

final class MeetingMinutePolicy
{
    use HasAdminPrivileges;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MeetingMinute $meetingMinute): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MeetingMinute $meetingMinute): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MeetingMinute $meetingMinute): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MeetingMinute $meetingMinute): bool
    {
        return $this->getAdminPrivileges($user);
    }
}
