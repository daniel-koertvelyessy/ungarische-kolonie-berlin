<?php

namespace App\Actions\Report;

use App\Models\Accounting\AccountReportAudit;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class CreateAccountReportAudit extends Action
{
    public static function handle(array $form): AccountReportAudit
    {
        return DB::transaction(function () use ($form) {

            return AccountReportAudit::create([
                'account_report_id' => $form['account_report_id'],
                'user_id' => $form['user_id'],

            ]);
        });

    }
}
