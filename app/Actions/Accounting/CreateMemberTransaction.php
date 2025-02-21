<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Illuminate\Support\Facades\DB;

class CreateMemberTransaction
{
    public static function handle(TransactionForm $form, Member $member): Transaction
    {
        return DB::transaction(function () use ($form, $member) {
            $transaction = CreateTransaction::handle($form);

            MemberTransaction::create([
                'transaction_id' => $transaction->id,
                'member_id' => $member->id,
            ]);

            return $transaction;
        });
    }
}
