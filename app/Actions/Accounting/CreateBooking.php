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

class CreateBooking extends Action
{
    public static function handle(array $data): Transaction
    {
     return   DB::transaction(function () use ($data)
        {
          Transaction::where('id', $data['id'])
                ->update([
                    'booking_account_id' => $data['booking_account_id'],
                    'status'             => $data['status'],
                ]);
          return Transaction::find($data['id']);
        });
//       /
    }

}
