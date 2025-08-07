<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Accounting;

use App\Models\Accounting\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

final class TransferTransactionForm extends Form
{
    public ?Transaction $transaction = null;

    public $account_id;

    public $transaction_id;

    public $user_id;

    public $reason;

    public function set(Transaction $transaction): void
    {
        $this->user_id = Auth::user()->id;
        $this->transaction_id = $transaction->id;
        $this->account_id = $transaction->label;
        $this->reason = $transaction->reference;
    }
}
