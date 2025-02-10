<?php

namespace App\Actions\Accounting;

use App\Enums\AccountType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Livewire\Event\Show\EventPayment;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\Membership\MemberTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateEventPayment
{
    public static function handle(array $data):bool
    {


         DB::transaction(function () use ($data)
        {


            $transaction =  Transaction::create([
                'label'              => $data['transaction']->label,
                'date'               => $data['transaction']->date,
                'amount_net'         => Account::makeCentInteger($data['transaction']->amount_gross),
                'vat'                => 0,
                'tax'                => 0,
                'amount_gross'       => Account::makeCentInteger($data['transaction']->amount_gross),
                'account_id'         => $data['account_id'],
                'booking_account_id' => $data['booking_account_id'],
                'type'               => $data['type'],
                'status'             => TransactionStatus::submitted->value,
            ]);

            if ($data['member_id'] !== 'extern') {
                MemberTransaction::create([
                    'label'          => $data['transaction']->label,
                    'date'           => $data['transaction']->date,
                    'amount'         => Account::makeCentInteger($data['transaction']->amount_gross),
                    'member_id'      => $data['member_id'],
                    'transaction_id' => $transaction->id,
                    'event_id'       => $data['event']->id,

                ]);
            }


        });


        return false;

    }

}
