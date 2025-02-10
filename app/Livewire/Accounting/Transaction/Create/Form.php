<?php

namespace App\Livewire\Accounting\Transaction\Create;

use App\Enums\TransactionType;
use App\Livewire\Forms\AccountForm;
use App\Livewire\Forms\BookingAccountForm;
use App\Livewire\Forms\ReceiptForm;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\BookingAccount;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public TransactionForm $form;
    public AccountForm $account;
    public ReceiptForm $receiptForm;
    public BookingAccountForm $booking;

    public ?Transaction $transaction = null;
    public $previewImagePath;

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

    protected $listeners = ['edit-transaction' => 'loadTransaction'];

    protected function makePreview(): void
    {
        $fileName = $this->receiptForm->generatePreview();
        $this->previewImagePath = url('/secure-image/'.$fileName);
    }

    public function loadTransaction(int $transactionId):void
    {
        $this->transaction = Transaction::find($transactionId);
        $this->form->set($this->transaction);
        if ($this->transaction->receipt_id) {
            $this->receiptForm->set(Receipt::find($this->transaction->receipt_id));
            $this->makePreview();
        }
    }

    public function mount(?int $transactionId = null)
    {
        if ($transactionId) {
            $this->transaction = Transaction::find($transactionId);
            $this->form->set($this->transaction);
            if ($this->transaction->receipt_id) {
                $this->receiptForm->set(Receipt::find($this->transaction->receipt_id));
                $this->makePreview();
            }
        } else {
            $this->form->type = TransactionType::Withdrawal->value;
            $this->form->vat = 19;
            $this->receiptForm->date = now()->format('Y-m-d');
            $this->form->date = now()->format('Y-m-d');
        }
    }

    public function submitTransaction(): void
    {
        $this->checkUser();

        if (($this->form->id)) {
            $this->transaction = $this->form->update();

            if ($this->transaction->save()) {
                $this->dispatch('transaction-updated');

                Flux::toast(
                    heading: 'Erfolg',
                    text: 'Die Buchung '.$this->form->label.' wurde aktualisiert',
                    variant: 'success',
                );

                Flux::modal('edit-transaction')
                    ->close();
            }
        } else {
            $this->transaction = $this->form->create();

            if ($this->transaction->save()) {
                //   $this->reset('transaction');

                Flux::toast(
                    heading: 'Erfolg',
                    text: 'Die Buchung '.$this->form->label.' wurde eingereicht',
                    variant: 'success',
                );
            }
        }
    }

    public function submitReceipt(): void
    {
        if (empty($this->receiptForm->file_name)) {
            Flux::modal('missing-transaction-modal')
                ->show();
            return;
        }

        $receipt = $this->receiptForm->updateFile();

        $this->transaction->receipt_id = $receipt->id;
        $this->form->receipt_id = $receipt->id;

        $this->previewImagePath = storage_path('app/private/accounting/receipts/previews/'.pathinfo($this->receiptForm->file_name, PATHINFO_FILENAME).'.png');


        if ($this->transaction->save()) {
            $this->reset('receiptForm');
            Flux::toast(
                heading: 'Erfolg',
                text: 'Die Buchung wurde eingereicht',
                variant: 'success',
            );
        }
    }

    public function deleteFile()
    {
        $file = $this->receiptForm->file_name;

        # Delete receipt model instance
        Receipt::destroy($this->transaction->receipt_id);
        $this->transaction->receipt_id = null;

        if ($this->transaction->save()) {
            Storage::disk('local')
                ->delete(('accounting/receipts/'.$file));

            Storage::disk('local')
                ->delete(storage_path('accounting/receipts/previews/'.pathinfo($file, PATHINFO_FILENAME).'.png'));

            if (Storage::disk('local')
                    ->missing('accounting/receipts/'.$file) && Storage::disk('local')
                    ->missing('accounting/receipts/previews/'.$file)) {
                $this->dispatch('receipt-deleted');
                Flux::toast(
                    heading: 'Erfolg',
                    text: 'Der Beleg wurde gelöscht',
                    variant: 'success',
                );
            }
        }
    }

    public function addAccount(): void
    {
        $this->checkUser();
        $this->account->create();
        $this->form->account_id = $this->account->id;
    }

    public function createAccount(): void
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
        } catch (AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'Sie haben keine Berechtigungen zur Erstellung von Konten'.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }
    }
}
