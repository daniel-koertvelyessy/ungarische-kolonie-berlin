<?php

namespace App\Actions\Accounting;

use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

class UpdateTransaction extends Action
{
    public static function handle(Transaction $transaction): Transaction
    {
        return DB::transaction(function () use ($transaction)
        {
            if ($transaction->update([
                'date'               => $transaction->date,
                'label'              => $transaction->label,
                'reference'          => $transaction->reference,
                'description'        => $transaction->description,
                'amount_gross'       => Account::makeCentInteger($transaction->amount_gross),
                'vat'                => $transaction->vat,
                'tax'                => Account::makeCentInteger($transaction->tax),
                'amount_net'         => Account::makeCentInteger($transaction->amount_net),
                'account_id'         => $transaction->account_id,
                'booking_account_id' => $transaction->booking_account_id,
                'type'               => $transaction->type,
                'status'             => $transaction->status,
            ])){
                return $transaction;
            } else {
                throw (new ModelNotFoundException())->setModel(Transaction::class);
            }
        });
    }

}
