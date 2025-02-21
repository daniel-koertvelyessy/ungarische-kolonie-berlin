<?php

namespace App\Policies;

use App\Enums\MemberType;
use App\Models\Accounting\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransactionPolicy
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
    public function view(User $user, Transaction $transaction): bool
    {
        return false;
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
    public function delete(User $user, Transaction $transaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return false;
    }

    public function addAccount(User $user): bool
    {

        if ($user->email === env('APP_ACCOUNTANT')) {
            return true;
        }

        return false;
    }

    private function checkThis(): bool
    {

        $user = Auth::user();

        if ($user->is_admin) {
            return true;
        }

        dd($user->is_admin);
        if ($user->member && $user->member->type === MemberType::MD->value) {
            return true;
        }

        return false;
    }
}
