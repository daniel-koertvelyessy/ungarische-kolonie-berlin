<?php

namespace App\Policies;

use App\Enums\MemberType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountPolicy
{
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

        return $this->checkThis();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->checkThis();
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

    public function bookItem()
    {
        return $this->checkThis();
    }

    private function checkThis(): bool
    {
        $user = Auth::user();

        // Check if user is admin
        if (property_exists($user, 'is_admin') && $user->is_admin) {
            return true;
        }

        // Check if user is the accountant
        if ($user->email === config('app.accountant')) {
            return true;
        }

        // Check if user is managing director
        if ($user->member !== null && 
            property_exists($user->member, 'type') && 
            $user->member->type === MemberType::MD->value) {
            return true;
        }

        return false;
    }
}
