<?php

namespace App\Actions\Accounting;

use App\Enums\AccountType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateTransaction
{
    public static function create(array $data): Transaction
    {
        return DB::transaction(function () use ($data)
        {
            return Transaction::create([
                'label'              => $data['label'],
                'amount_net'         => Account::makeCentInteger($data['amount_net']),
                'vat'                => Account::makeCentInteger($data['vat']),
                'tax'                => Account::makeCentInteger($data['tax']),
                'amount_gross'       => Account::makeCentInteger($data['amount_gross']),
                'account_id'         => $data['account_id'],
                'booking_account_id' => $data['booking_account_id'],
                'type'               => $data['type'],
                'status'             => $data['status'],
            ]);
        });
    }

}
