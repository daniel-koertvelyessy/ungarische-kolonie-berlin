<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\Event;
use App\Models\EventTransaction;
use Illuminate\Support\Facades\DB;

class CreateEventTransaction
{
    /**
     * @param  Transaction  $transaction
     * @param  Event  $event
     * @param $name
     * @param $gender
     * @return bool
     * @throws \Throwable
     */
    public static function handle(Transaction $transaction, Event $event, $name, $gender): bool
    {
        DB::transaction(function () use ($transaction, $event, $name, $gender)
        {

            EventTransaction::create([
                'visitor_name'   => $name,
                'gender'         => $gender,
                'transaction_id' => $transaction->id,
                'event_id'       => $event->id,
            ]);

            return true;
        });


        return false;
    }

}
