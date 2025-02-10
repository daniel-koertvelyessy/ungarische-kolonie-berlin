<?php

namespace App\Actions\Accounting;

use App\Enums\AccountType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class UpdateTransaction extends Action
{
    public static function handle(array $data): Transaction
    {
        DB::transaction(function () use ($data)
        {
            Transaction::where('id', $data['id'])
                ->update([
                    'label'              => $data['label'],
                    'date'               => $data['date'],
                    'amount_net'         => Account::makeCentInteger($data['amount_net']),
                    'vat'                => Account::makeCentInteger($data['vat']),
                    'tax'                => Account::makeCentInteger($data['tax']),
                    'amount_gross'       => Account::makeCentInteger($data['amount_gross']),
                    'account_id'         => $data['account_id'],
                    'booking_account_id' => $data['booking_account_id'],
                    'type'               => $data['type'],
                    'status'             => $data['status'],
                    'receipt_id'         => $data['receipt_id'],
                ]);
        });
        return Transaction::find($data['id']);
    }

}
