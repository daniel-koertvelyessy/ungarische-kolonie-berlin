<?php

namespace App\Actions\Accounting;

use App\Enums\TransactionType;
use App\Livewire\Forms\Accounting\TransferTransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class TransferTransaction
{
    public static function handle(Transaction $transaction, TransferTransactionForm $from): Transaction
    {
        return DB::transaction(function () use ($transaction, $from) {
            $ct = \App\Models\Accounting\CancelTransaction::create([
                'transaction_id' => $transaction->id,
                'user_id' => $from->user_id,
                'reason' => $from->reason,
            ]);

            $oldType = $transaction->type;

            $transaction->amount_gross = $transaction->amount_gross * -1;
            $transaction->vat = $transaction->vat * -1;
            $transaction->tax = $transaction->tax * -1;
            $transaction->type = TransactionType::Reversal->value;
            $transaction->save();

            return Transaction::create([
                'date' => Carbon::now('Europe/Berlin'),
                'label' => $transaction->label,
                'reference' => $transaction->reference,
                'description' => $transaction->description.'Umbgebucht: '.$from->reason,
                'amount_gross' => Account::makeCentInteger($transaction->amount_gross),
                'vat' => $transaction->vat,
                'tax' => Account::makeCentInteger($transaction->tax),
                'amount_net' => Account::makeCentInteger($transaction->amount_net),
                'account_id' => $from->account_id,
                'booking_account_id' => $transaction->booking_account_id,
                'type' => $oldType,
                'status' => $transaction->status,
            ]);
        });
    }
}
