<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Support\Facades\DB;

class CreateTransaction
{
    public static function handle(TransactionForm $form): Transaction
    {
        return DB::transaction(function () use ($form)
        {
            return Transaction::create([
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


        });

    }

}
