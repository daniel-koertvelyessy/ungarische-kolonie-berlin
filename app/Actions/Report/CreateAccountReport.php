<?php

namespace App\Actions\Report;

use App\Livewire\Forms\Accounting\AccountReportForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\AccountReport;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class CreateAccountReport extends Action
{
    public static function handle(AccountReportform $form): AccountReport
    {
        return DB::transaction(function () use ($form) {
            return AccountReport::create([
                'account_id' => $form->account_id,
                'starting_amount' => Account::makeCentInteger($form->starting_amount),
                'end_amount' => Account::makeCentInteger($form->end_amount),
                'created_by' => $form->created_by,
                'period_start' => $form->period_start,
                'period_end' => $form->period_end,
                'total_income' => Account::makeCentInteger($form->total_income),
                'total_expenditure' => Account::makeCentInteger($form->total_expenditure),
                'status' => $form->status,
                'notes' => $form->notes,
            ]);
        });

    }
}
