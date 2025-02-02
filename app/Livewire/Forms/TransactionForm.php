<?php

namespace App\Livewire\Forms;

use App\Enums\TransactionType;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransactionForm extends Form
{
    public TransactionType $transaction_type;
    public $amount_net;
    public int $vat = 19;
    public $tax;
    public $amount_gross;
    public $account;
    public $receipt;
    public $booking_account_id;




}
