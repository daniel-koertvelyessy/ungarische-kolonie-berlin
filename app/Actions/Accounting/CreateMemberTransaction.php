<?php

namespace App\Actions\Accounting;

use App\Enums\AccountType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\Membership\MemberTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateMemberTransaction
{
    public static function handle(array $data): MemberTransaction
    {
        return DB::transaction(function () use ($data)
        {
            $transaction = Transaction::create([
                'label'              => $data['label'],
                'date'               => $data['date'],
                'amount_net'         => Account::makeCentInteger($data['amount']),
                'vat'                => Account::makeCentInteger($data['vat']),
                'tax'                => $data['tax'],
                'amount_gross'       => Account::makeCentInteger($data['amount']),
                'account_id'         => $data['account_id'],
                'booking_account_id' => $data['booking_account_id'],
                'type'               => TransactionType::Deposit->value,
                'status'             => TransactionStatus::booked->value,
            ]);

            return MemberTransaction::create([
                'date'           => $data['date'],
                'label'          => $data['label'],
                'amount'         => Account::makeCentInteger($data['amount']),
                'member_id'      => $data['member_id'],
                'transaction_id' => $transaction->id,
                'event_id'       => $data['event_id'],

            ]);
        });
    }

}
