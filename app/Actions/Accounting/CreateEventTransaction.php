<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use App\Models\Event\EventTransaction;
use Illuminate\Support\Facades\DB;

class CreateEventTransaction
{
    public static function handle(TransactionForm $form, Event $event, $name, $gender): Transaction
    {
        return DB::transaction(function () use ($form, $event, $name, $gender)
        {
            $transaction = CreateTransaction::handle($form);

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
