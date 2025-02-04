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
    use WithFileUploads;

    public TransactionForm $form;
    public AccountForm $account;
    public ReceiptForm $receipt;
    public BookingAccountForm $booking;

    public Transaction $transaction;

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

    public function mount(){
        $this->form->type = TransactionType::Withdrawal->value;
        $this->form->vat = 19;
        $this->receipt->date = now()->format('Y-m-d');
    }

    public function submitTransaction():void
    {
        $this->checkUser();

      $this->transaction =  $this->form->create();

      if ($this->transaction->save()) {
          $this->reset( 'transaction');

          Flux::toast(
              heading: 'Erfolg',
              text: 'Die Buchung '.$this->form->label.' wurde eingereicht',
              variant: 'success',
          );
      }
    }

    public function submitReceipt():void
    {
        if(empty($this->receipt->file_name)){
            Flux::modal('missing-transaction-modal')->show();
          return;
        }

        $receipt = $this->receipt->updateFile();

        $this->transaction->receipt_id = $receipt->id;
        $this->form->receipt_id = $receipt->id;

        if ($this->transaction->save()) {
            $this->reset('receipt');
            Flux::toast(
                heading: 'Erfolg',
                text: 'Die Buchung wurde eingereicht',
                variant: 'success',
            );
        }
    }
    public function addAccount():void
    {
        $this->checkUser();
        $this->account->create();
        $this->form->account_id = $this->account->id;

    }

    public function createAccount():void
    {
        $this->checkUser();
        $this->account->create();
        $this->reset('account');

    }


    public function addBookingAccount(): void
    {
        $this->checkUser();
        $this->booking->create();
        $this->form->booking_id = $this->booking->id;

    }

    public function createBookingAccount(): void
    {
        $this->checkUser();
        $this->booking->create();
        $this->reset('booking');
    }

    protected function checkUser(): void
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
    }
}
