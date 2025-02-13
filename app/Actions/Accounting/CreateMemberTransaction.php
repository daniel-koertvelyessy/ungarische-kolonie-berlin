<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Illuminate\Support\Facades\DB;

class CreateMemberTransaction
{
    public static function handle(Transaction $transaction, Member $member): bool
    {
        DB::transaction(function () use ($transaction, $member)
        {
            MemberTransaction::create([
                'transaction_id' => $transaction->id,
                'member_id'      => $member->id,
            ]);

            return true;
        });

        return false;
    }

}
