<?php

namespace App\Policies;

use App\Enums\MemberType;
use App\Models\Membership\Member;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MemberPolicy
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
    public function view(): bool
    {
       return $this->checkThis();

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
      return $this->checkThis();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Member $member): bool
    {

        if($user->member && $user->member->id == $member->id){
            return true;
        }

        if ($user->member && $user->member->type === MemberType::MD->value) {
            return true;
        }

        return $this->checkThis();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return true;
        }

        if ($user->is_BoardMember) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Member $member): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Member $member): bool
    {
        return false;
    }

    private function checkThis(): bool
    {

        $user = Auth::user();

        if ($user->is_admin) {
            return true;
        }


        if ($user->member && $user->member->type === MemberType::MD->value) {
            return true;
        }

        return false;
    }
}
