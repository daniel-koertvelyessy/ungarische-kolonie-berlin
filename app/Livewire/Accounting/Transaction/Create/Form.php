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
use App\Models\Event;
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

    public bool $check_form = false;

    protected $listeners = ['edit-transaction' => 'loadTransaction','fileDropped'];

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
//        if ($this->transaction->receipts->count() > 0) {
//            $this->receiptForm->set(Receipt::find($this->transaction->receipt_id));
//        }


    }

    public function mount(?int $transactionId = null)
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

        if (isset($this->event)) {

            $this->handleEventTransaction($this->transaction);

        }

        if ($this->visitor_has_member_id) {
            $this->handleMemberTransaction($this->transaction, Member::find($this->visitor_has_member_id));
        }

        if (isset($this->member)) {

            $this->handleMemberTransaction($this->transaction, $this->member);

        }

        $this->dispatch('updated-payments');

    }

    protected function handleTransaction(): Transaction
    {
        $transaction =  isset($this->transaction)
            ? UpdateTransaction::handle($this->transaction)
            : CreateTransaction::handle($this->form);

        $this->form->id = $transaction->id;

        if(isset($this->receiptForm->file_name)){
            $this->submitReceipt();
        }

        Flux::toast(
            heading: 'Erfolg',
            text: 'Die Buchung wurde erfasst',
            variant: 'success',
        );

        return $transaction;

    }

    protected function handleEventTransaction(Transaction $transaction): void
    {
        $this->validate([
            'event'        => 'required',
            'visitor_name' => 'required',
            'gender'       => 'required',
        ], [
            'event.required'        => 'Event is required.',
            'visitor_name.required' => 'Der Gast hat noch keinen Namen',
        ]);

        try {
            CreateEventTransaction::handle($transaction, $this->event, $this->visitor_name, $this->gender);

            Flux::toast(
                heading: 'Erfolg',
                text: 'Die Buchung für die Veranstaung wurde erfasst',
                variant: 'success',
            );
        } catch (\Throwable $e) {
            Flux::toast(
                heading: 'Fehler',
                text: 'Die Transaktion konnte nicht gespeichert werden: '.$e->getMessage(),
                variant: 'error',
            );

            // Optional: Log the error
            Log::error('Transaction creation failed', ['error' => $e->getMessage()]);
        }
    }

    protected function handleMemberTransaction(Transaction $transaction, Member $member): void
    {
        $id = $this->visitor_has_member_id || $member->id;

        try {
            CreateMemberTransaction::handle($transaction, $member);
            Flux::toast(
                heading: 'Erfolg',
                text: 'Die Buchung des Mitgliedsbeitrages wurde erfasst',
                variant: 'success',
            );
        } catch (\Throwable $e) {
            Flux::toast(
                heading: 'Fehler',
                text: 'Die Transaktion konnte nicht gespeichert werden: '.$e->getMessage(),
                variant: 'error',
            );

            // Optional: Log the error
            Log::error('Transaction creation failed', ['error' => $e->getMessage()]);
        }
    }




    public function submitReceipt(): void
    {


        if (empty($this->form->id)) {
            Flux::modal('missing-transaction-modal')
                ->show();
            return;
        }

        $this->receiptForm->updateFile($this->form->id);

        $this->previewImagePath = storage_path('app/private/accounting/receipts/previews/'.pathinfo($this->receiptForm->file_name, PATHINFO_FILENAME).'.png');

    //    $this->dispatch('edit-transaction');

        $this->reset('receiptForm');


        Flux::toast(
            heading: 'Erfolg',
            text: 'Der Beleg wurde eingereicht',
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

        # Delete receipt model instance
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
                heading: 'Erfolg',
                text: 'Die Datei wurde gelöscht',
                variant: 'success',
            );
        }

        $this->dispatch('edit-transaction');

    }

    public function resetTransactionForm():void
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
                heading: 'Forbidden',
                text: 'Sie haben keine Berechtigungen zur Erstellung von Konten'.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }
    }
}
