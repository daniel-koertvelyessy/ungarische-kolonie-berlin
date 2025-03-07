<?php

namespace App\Policies;

use App\Models\Accounting\AccountReportAudit;
use App\Models\User;
use App\Policies\Traits\HasAdminPrivileges;

class AccountReportAuditPolicy
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
    public function view(User $user, AccountReportAudit $accountReportAudit): bool
    {
        return false;
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
    public function update(User $user, AccountReportAudit $accountReportAudit): bool
    {
        if ($user->id === $accountReportAudit->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AccountReportAudit $accountReportAudit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AccountReportAudit $accountReportAudit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AccountReportAudit $accountReportAudit): bool
    {
        return false;
    }

    public function audit(User $user, AccountReportAudit $accountReportAudit): bool
    {

        if ($user->id === $accountReportAudit->user_id) {

            return true;
        }

        return false;
    }
}
