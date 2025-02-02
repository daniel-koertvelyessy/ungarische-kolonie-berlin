<?php

namespace App\Livewire\Accounting\Transaction\Create;

use App\Actions\Accounting\CreateAccount;
use App\Enums\TransactionType;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\BookingAccount;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Page extends Component
{
    use WithFileUploads;

    public TransactionForm $form;

    public $account_name;
    public $account_number;
    public $account_institute;
    public $account_iban;
    public $account_bic;

    public bool $check_form = false;

    #[Computed]
    public function accounts()
    {
        return Account::select('id', 'name')
            ->get();
    }

    #[Computed]
    public function booking_accounts()
    {
        return BookingAccount::select('id', 'label', 'number')
            ->get();
    }

    public function addNewAccount(): void
    {
        try {
            $this->authorize('create', Account::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'Sie haben keine Berechtigungen zur Erstellung von Konten'.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }


        CreateAccount::create([
            'name'      => $this->account_name,
            'number'    => $this->account_number,
            'institute' => $this->account_institute,
            'iban'      => $this->account_iban,
            'bic'       => $this->account_bic,
        ]);
    }


    public function addNewBookingAccount()
    {
        try {
            $this->authorize('create', Account::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'Sie haben keine Berechtigungen zur Erstellung von Konten'.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        CreateAccount::create([
            'type'   => $this->booking_account_type,
            'number' => $this->booking_account_number,
            'label'  => $this->booking_account_label,
        ]);
    }


    public function render()
    {
        return view('livewire.accounting.transaction.create.page');
    }
}
