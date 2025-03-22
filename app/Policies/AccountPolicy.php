<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Traits\HasAdminPrivileges;
use Illuminate\Support\Facades\Auth;

class AccountPolicy
{
    use HasAdminPrivileges;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        // Check if user has verified email and has a member relationship with matching email
        return $user->hasVerifiedEmail() &&
            $user->member !== null &&
            property_exists($user->member, 'email') &&
            $user->member->email === $user->email;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {

        return $this->getAdminPrivileges(Auth::user());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->getAdminPrivileges(Auth::user());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return false;
    }

    public function audit($user, $audit): bool
    {
        return false;
    }

    public function bookItem(): bool
    {
        return $this->getAdminPrivileges(Auth::user());
    }
}
