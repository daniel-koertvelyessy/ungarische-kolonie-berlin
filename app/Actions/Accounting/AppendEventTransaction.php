<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\Event;
use App\Models\EventTransaction;
use Illuminate\Support\Facades\DB;

class AppendEventTransaction
{
    public static function handle(Transaction $transaction, Event $event, $name, $gender): Transaction
    {
      return  DB::transaction(function () use ($transaction, $event, $name, $gender)
        {

            EventTransaction::create([
                'visitor_name'   => $name,
                'gender'         => $gender,
                'transaction_id' => $transaction->id,
                'event_id'       => $event->id,
            ]);

            return $transaction;
        });


    }

}
