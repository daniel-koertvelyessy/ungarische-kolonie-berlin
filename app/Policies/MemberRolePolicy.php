<?php

namespace App\Policies;

use App\Models\Membership\MemberRole;
use App\Models\User;
use App\Policies\Traits\HasAdminPrivileges;

class MemberRolePolicy
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
    public function view(User $user, MemberRole $memberRole): bool
    {
        return $user->exists();
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
    public function update(User $user, MemberRole $memberRole): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MemberRole $memberRole): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MemberRole $memberRole): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MemberRole $memberRole): bool
    {
        return $this->getAdminPrivileges($user);
    }
}
