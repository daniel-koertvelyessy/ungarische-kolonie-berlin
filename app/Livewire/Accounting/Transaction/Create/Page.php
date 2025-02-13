<?php

namespace App\Livewire\Accounting\Transaction\Create;

use App\Actions\Accounting\CreateAccount;
use App\Actions\Accounting\CreateBookingAccount;
use App\Enums\TransactionType;
use App\Livewire\Forms\AccountForm;
use App\Livewire\Forms\BookingAccountForm;
use App\Livewire\Forms\ReceiptForm;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\BookingAccount;
use App\Models\Accounting\Transaction;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Page extends Component
{
    public function render()
    {
        return view('livewire.accounting.transaction.create.page');
    }
}
