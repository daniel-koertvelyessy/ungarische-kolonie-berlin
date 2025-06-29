<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Accounting;

use App\Models\Accounting\Transaction;
use Livewire\Form;

class EditTextTransactionForm extends Form
{
    public ?Transaction $transaction = null;

    public $label;

    public $reference;

    public $description;

    public function set(Transaction $transaction): void
    {
        $this->transaction = $transaction;
        $this->label = $transaction->label;
        $this->reference = $transaction->reference;
        $this->description = $transaction->description;
    }

    public function update()
    {
        return $this->transaction->update([
            'label' => $this->label,
            'reference' => $this->reference,
            'description' => $this->description,
        ]);
    }
}
