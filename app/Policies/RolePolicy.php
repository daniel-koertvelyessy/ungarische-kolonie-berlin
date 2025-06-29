<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Membership\Role;
use App\Models\User;
use App\Policies\Traits\HasAdminPrivileges;

class RolePolicy
{
    use HasAdminPrivileges;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
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
    public function update(User $user, Role $role): bool
    {
        return $this->getAdminPrivileges($user);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        return $this->getAdminPrivileges($user);

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        return $this->getAdminPrivileges($user);

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $this->getAdminPrivileges($user);

    }
}
