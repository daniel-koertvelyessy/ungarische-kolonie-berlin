<?php

declare(strict_types=1);

namespace App\Actions\Accounting;

use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Illuminate\Support\Facades\DB;

final class AppendMemberTransaction
{
    public static function handle(Transaction $transaction, Member $member): bool
    {
        DB::transaction(function () use ($transaction, $member) {
            MemberTransaction::create([
                'transaction_id' => $transaction->id,
                'member_id' => $member->id,
            ]);

            return true;
        });

        return false;
    }
}
