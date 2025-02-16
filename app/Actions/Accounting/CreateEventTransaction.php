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
    public static function handle(TransactionForm $form, Event $event, $name, $gender): Transaction
    {
      return  DB::transaction(function () use ($form, $event, $name, $gender)
        {

            $transaction = Transaction::create([
                'date'               => $form->date,
                'label'              => $form->label,
                'reference'          => $form->reference,
                'description'        => $form->description,
                'amount_gross'       => Account::makeCentInteger($form->amount_gross),
                'vat'                => $form->vat,
                'tax'                => Account::makeCentInteger($form->tax),
                'amount_net'         => Account::makeCentInteger($form->amount_net),
                'account_id'         => $form->account_id,
                'booking_account_id' => $form->booking_account_id,
                'type'               => $form->type,
                'status'             => $form->status,
            ]);



            EventTransaction::create([
                'visitor_name'   => $name,
                'gender'         => $gender,
                'transaction_id' => $transaction->id,
                'event_id'       => $event->id,
            ]);

            return $transaction;
        });


        return false;
    }

}
