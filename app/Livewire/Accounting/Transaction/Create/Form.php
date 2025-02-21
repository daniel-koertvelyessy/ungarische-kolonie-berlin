<?php

namespace App\Livewire\Accounting\Transaction\Create;

use App\Actions\Accounting\CreateEventTransaction;
use App\Actions\Accounting\CreateMemberTransaction;
use App\Actions\Accounting\CreateTransaction;
use App\Actions\Accounting\UpdateTransaction;
use App\Enums\Gender;
use App\Enums\TransactionType;
use App\Livewire\Forms\AccountForm;
use App\Livewire\Forms\BookingAccountForm;
use App\Livewire\Forms\ReceiptForm;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\BookingAccount;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use App\Models\Membership\Member;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public Event $event;

    public $visitor_name;

    public $gender = Gender::ma->value;

    public $visitor_has_member_id;

    public $external_visitor_name;

    public Member $member;

    public TransactionForm $form;

    public AccountForm $account;

    public ReceiptForm $receiptForm;

    public BookingAccountForm $booking;

    public ?Transaction $transaction = null;

    public $previewImagePath;

    public $selectedMember;

    public $entry_fee;

    public $entry_fee_discounted;

    public $visitors = [];

    public $tmp_transaction_id;

    public bool $check_form = false;

    protected $listeners = ['edit-transaction' => 'loadTransaction', 'fileDropped'];

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

    public function updatedSelectedMember($value): void
    {
        if ($value === 'extern') {
            $this->visitor_name = '';
            $this->visitor_has_member_id = false;
        } else {
            $member = \App\Models\Membership\Member::find($value);
            $this->visitor_name = $member ? $member->fullName() : '';
            $this->visitor_has_member_id = $value;
        }
    }

    public function loadTransaction($transactionId): void
    {
        $this->transaction = Transaction::find($transactionId);
        $this->form->set($this->transaction);
    }

    public function mount(?int $transactionId = null): void
    {
        if ($transactionId !== null) {
            $this->transaction = Transaction::find($transactionId);

            if ($this->transaction) {
                $this->form->set($this->transaction);
            }
        } else {
            $this->resetTransactionForm();
        }

        if (isset($this->event)) {
            $this->entry_fee = $this->event->entry_fee;
            $this->entry_fee_discounted = $this->event->entry_fee_discounted;
        }
    }

    public function submitTransaction(): void
    {
        $this->checkUser();

        $this->form->validate();

        $this->transaction = $this->handleTransaction();

        $this->dispatch('updated-payments');
        //        $this->redirect(route('transaction.index'));

    }

    public function submitEventTransaction(): void
    {
        $this->checkUser();
        $this->handleEventTransaction();

        if ($this->visitor_has_member_id) {
            $this->handleMemberTransaction($this->form, Member::find($this->visitor_has_member_id), true);
        }
    }

    public function submitMemberTransaction(): void
    {
        $this->checkUser();
        $this->handleMemberTransaction($this->form, $this->member);
    }

    protected function handleTransaction(): Transaction
    {

        if (isset($this->transaction)) {

            UpdateTransaction::handle($this->form);
            $this->tmp_transaction_id = $this->transaction->id;
            Flux::toast(
                text: 'Die Buchung '.$this->transaction->label.' wurde aktualisiert',
                heading: 'Erfolg',
                variant: 'success',
            );
        } else {
            $this->transaction = CreateTransaction::handle($this->form);
            Flux::toast(
                text: 'Die Buchung '.$this->transaction->label.' wurde erfasst',
                heading: 'Erfolg',
                variant: 'success',
            );
        }

        if (isset($this->receiptForm->file_name)) {
            $this->submitReceipt();
        }

        return $this->transaction;
    }

    protected function handleEventTransaction()
    {
        $this->validate([
            'form.account_id' => ['required', 'doesnt_start_with:new'],
            'transaction.id' => 'unique:event_transactions,transaction_id',
            'event' => 'required',
            'visitor_name' => 'required',
            'gender' => 'required',
        ], [
            'form.account_id.required' => 'Bitte Zahlungskonto angeben',
            'form.account_id.doesnt_start_with' => 'Bitte Zahlungskonto angeben oder anlegen',
            'event.required' => 'Event is required.',
            'visitor_name.required' => 'Der Gast hat noch keinen Namen',
            'transaction.id.unique' => 'Diese Buchung wurde bereits vergeben.',
        ]);

        /*      if (isset($this->transaction)){
                  try {
                      UpdateEventTransaction::handle($this->transaction,$this->event, $this->visitor_name, $this->gender );
                      Flux::toast(
                          text: 'Die Buchung '.$this->transaction->label.' wurde aktualisiert',
                          heading: 'Erfolg',
                          variant: 'success',
                      );
                  } catch (\Throwable $e) {
                      Flux::toast(
                          text: 'Die Transaktion konnte nicht gespeichert werden: '.$e->getMessage(),
                          heading: 'Fehler',
                          duration: 0,
                          variant: 'error',
                      );
                      Log::error('Transaction creation failed', ['error' => $e->getMessage()]);
                  }


              } else{*/
        try {
            if (isset($this->receiptForm->file_name)) {
                $this->transaction = CreateEventTransaction::handle($this->form, $this->event, $this->visitor_name, $this->gender);
                $this->submitReceipt();
            } else {
                CreateEventTransaction::handle($this->form, $this->event, $this->visitor_name, $this->gender);
            }

            Flux::toast(
                text: 'Die Buchung für die Veranstaung wurde erfasst',
                heading: 'Erfolg',
                variant: 'success',
            );
        } catch (\Throwable $e) {
            Flux::toast(
                text: 'Die Transaktion konnte nicht gespeichert werden: '.$e->getMessage(),
                heading: 'Fehler',
                duration: 0,
                variant: 'error',
            );
            Log::error('Transaction creation failed', ['error' => $e->getMessage()]);
        }
        //        }

        if (isset($this->receiptForm->file_name)) {
            $this->submitReceipt();
        }

        return $this->transaction;
    }

    protected function handleMemberTransaction(TransactionForm $form, Member $member): void
    {
        try {
            CreateMemberTransaction::handle($form, $member);

            Flux::toast(
                text: 'Die Buchung des Mitgliedsbeitrages wurde erfasst',
                heading: 'Erfolg',
                variant: 'success',
            );
        } catch (\Throwable $e) {
            Flux::toast(
                text: 'Die Transaktion konnte nicht gespeichert werden: '.$e->getMessage(),
                heading: 'Fehler',
                duration: 0,
                variant: 'error'
            );

            // Optional: Log the error
            Log::error('Transaction creation failed', ['error' => $e->getMessage()]);
        }
    }

    public function submitReceipt(): void
    {
        if (empty($this->transaction->id)) {
            Flux::modal('missing-transaction-modal')
                ->show();

            return;
        }

        $this->receiptForm->updateFile($this->transaction->id);

        $this->previewImagePath = storage_path('app/private/accounting/receipts/previews/'.pathinfo($this->receiptForm->file_name, PATHINFO_FILENAME).'.png');

        //    $this->dispatch('edit-transaction');

        $this->reset('receiptForm');

        Flux::toast(
            text: 'Der Beleg wurde eingereicht',
            heading: 'Erfolg',
            variant: 'success',
        );
    }

    public function fileDropped($file)
    {
        $this->receiptForm['file_name'] = $file;
    }

    public function deleteFile(int $receipt_id): void
    {
        $receipt = Receipt::find($receipt_id);
        $file = $receipt->file_name;

        // Delete receipt model instance
        $receipt->delete();

        Storage::disk('local')
            ->delete(('accounting/receipts/'.$file));

        Storage::disk('local')
            ->delete(storage_path('accounting/receipts/previews/'.pathinfo($file, PATHINFO_FILENAME).'.png'));

        if (Storage::disk('local')
            ->missing('accounting/receipts/'.$file) && Storage::disk('local')
            ->missing('accounting/receipts/previews/'.$file)) {
            $this->dispatch('receipt-deleted');
            Flux::toast(
                text: 'Die Datei wurde gelöscht',
                heading: 'Erfolg',
                variant: 'success',
            );
        }

        $this->dispatch('edit-transaction');
    }

    public function resetTransactionForm(): void
    {
        $this->form->reset();
        $this->form->type = TransactionType::Withdrawal->value;
        $this->form->vat = 19;
        $this->form->date = now()->format('Y-m-d');
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

    public function addVisitor(): void
    {
        $this->visitors[] = $this->visitors->name;
    }

    protected function checkUser(): void
    {
        try {
            $this->authorize('create', Account::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: 'Sie haben keine Berechtigungen zur Erstellung von Konten'.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }
    }
}
