<?php

namespace App\Policies;

use App\Enums\MemberType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EventPolicy
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
        return true;
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
    public function update(): bool
    {
        return $this->checkThis();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return $this->checkThis();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return $this->checkThis();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return $this->checkThis();
    }

    private function checkThis(): bool
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return true;
        }

        if ($user->member->type === MemberType::MD->value) {
            return true;
        }

        return false;
    }
}
