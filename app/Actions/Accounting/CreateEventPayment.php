<?php

namespace App\Actions\Accounting;

use App\Enums\AccountType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Livewire\Event\Show\EventPayment;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\EventTransaction;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateEventPayment
{
    public static function handle(array $data): bool
    {
        DB::transaction(function () use ($data)
        {
            $transaction = Transaction::create([
                'label'              => $data['transaction']->label,
                'date'               => $data['transaction']->date,
                'amount_net'         => Account::makeCentInteger($data['transaction']->amount_gross),
                'vat'                => 0,
                'tax'                => 0,
                'amount_gross'       => Account::makeCentInteger($data['transaction']->amount_gross),
                'account_id'         => $data['transaction']->account_id,
                'booking_account_id' => $data['transaction']->booking_account_id,
                'type'               => $data['transaction']->type,
                'status'             => TransactionStatus::booked->value,
            ]);

            if ($data['member_id'] !== 'extern') {
                $member = Member::findOrFail($data['member_id']);
                MemberTransaction::create([
                    'label'          => $data['transaction']->label,
                    'date'           => $data['transaction']->date,
                    'amount'         => Account::makeCentInteger($data['transaction']->amount_gross),
                    'member_id'      => $data['member_id'],
                    'transaction_id' => $transaction->id,
                    'event_id'       => $data['event']->id,

                ]);

                EventTransaction::create([
                    'label'          => $data['transaction']->label,
                    'date'           => $data['transaction']->date,
                    'amount'         => Account::makeCentInteger($data['transaction']->amount_gross),
                    'name'           => $member->fullName(),
                    'transaction_id' => $transaction->id,
                    'event_id'       => $data['event']->id,
                ]);

            } else {
                EventTransaction::create([
                    'label'          => $data['transaction']->label,
                    'date'           => $data['transaction']->date,
                    'amount'         => Account::makeCentInteger($data['transaction']->amount_gross),
                    'name'           => 'extern',
                    'transaction_id' => $transaction->id,
                    'event_id'       => $data['event']->id,
                ]);
            }
        });


        return false;
    }

}
