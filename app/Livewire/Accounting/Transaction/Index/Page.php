<?php

namespace App\Livewire\Accounting\Transaction\Index;

use App\Actions\Accounting\AppendEventTransaction;
use App\Actions\Accounting\AppendMemberTransaction;
use App\Enums\DateRange;
use App\Enums\Gender;
use App\Enums\TransactionType;
use App\Livewire\Forms\ReceiptForm;
use App\Livewire\Traits\Sortable;
use App\Models\Accounting\Account;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use App\Models\Event\EventTransaction;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Page extends Component
{
    use Sortable, WithPagination;

    protected $listeners = ['transaction-updated'];

    public ReceiptForm $receipt;

    public ?Transaction $transaction = null;

    #[Url]
    public $search;

    #[Url]
    public array $filter_status = ['eingereicht', 'gebucht'];

    public array $filter_type = [];

    public $selectedTransactions = [];

    public $numTransactions;

    public $transactionsOnPage = [];

    public $allTransactions = [];

    public $filter_date_range = DateRange::All->value;

    #[Validate]
    public $target_event;

    #[Validate]
    public $target_member;

    public $event_visitor_name;

    public $event_gender;

    public $changeTextLabel;

    public $changeTextReference;

    public $changeTextDescription;

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function transactions(): LengthAwarePaginator
    {
        $this->allTransactions = Transaction::all()
            ->map(fn ($transaction) => (string) $transaction->id)
            ->toArray();

        $date_range = DateRange::from($this->filter_date_range)
            ->dates();

        $transactionList = \App\Models\Accounting\Transaction::query()
            ->with('event_transaction')
            ->with('member_transaction')
            ->tap(fn ($query) => $this->search ? $query->where('label', 'LIKE', '%'.$this->search.'%') : $query)
            ->whereIn('status', $this->filter_status)
            ->whereIn('type', $this->filter_type)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn ($query) => $this->filter_date_range === DateRange::All->value ? $query : $query->whereBetween('date', $date_range))
//            ->tap(fn($query) => logger()->info($query->toSql(), $query->getBindings()))
            ->paginate(15)
            ->through(fn ($transaction) => $transaction->refresh());

        $this->transactionsOnPage = $transactionList->map(fn ($transaction) => (string) $transaction->id)
            ->toArray();

        return $transactionList;
    }

    public function mount()
    {
        $this->filter_type = TransactionType::toArray();
    }

    public function download(int $receipt_id): StreamedResponse
    {
        $receipt = Receipt::findOrFail($receipt_id);

        $filePath = "accounting/receipts/{$receipt->file_name}";

        // Debugging: Check if the file exists
        if (! Storage::disk('local')
            ->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')
            ->download($filePath, $receipt->file_name_original);
    }

    public function bookItem(int $transaction_id): void
    {
        $this->authorize('book-item', Account::class);
        $this->dispatch('book-transaction', transactionId: $transaction_id);
        $this->transaction = Transaction::find($transaction_id);
        Flux::modal('book-transaction')
            ->show();
    }

    public function editItem(int $transaction_id): void
    {
        $this->authorize('update', Account::class);
        $this->dispatch('edit-transaction', transactionId: $transaction_id);
        $this->transaction = Transaction::find($transaction_id);

        Flux::modal('edit-transaction')
            ->show();
    }

    public function detachMember(int $member_transaction_id): void
    {
        $this->checkUser();
        MemberTransaction::findOrFail($member_transaction_id)
            ->delete();
        Flux::toast(
            text: __('transaction.detach-member-success.text'),
            heading: __('transaction.detach-member-success.heading'),
            variant: 'success',
        );
    }

    public function detachEvent(int $event_transaction_id): void
    {
        $this->checkUser();
        if (EventTransaction::findOrFail($event_transaction_id)
            ->delete()) {
            Flux::toast(
                text: __('transaction.detach-event-success.text'),
                heading: __('transaction.detach-event-success.heading'),
                variant: 'success',
            );
        }
    }

    public function cancelItem(int $transaction_id)
    {

        $this->checkUser();

        $transaction = Transaction::findOrFail($transaction_id);
        Flux::modal('cancel-transaction')->show();

    }

    public function appendToEvent(int $transaction_id): void
    {
        try {
            $this->authorize('create', Transaction::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: __('transaction.access.denied').$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }

        $this->transaction = Transaction::findOrFail($transaction_id);
        Flux::modal('append-to-event-transaction')
            ->show();
    }

    public function appendToMember(int $transaction_id): void
    {
        try {
            $this->authorize('create', Transaction::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: __('transaction.access.denied').$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }

        $this->transaction = Transaction::findOrFail($transaction_id);
        Flux::modal('append-to-member-transaction')
            ->show();
    }

    public function appendEvent(): void
    {
        $this->checkUser();
        $this->validate([
            'transaction.id' => ['unique:event_transactions,transaction_id'],
            'target_event' => 'required',
            'event_visitor_name' => '',
            'event_gender' => ['nullable', Rule::enum(Gender::class)],
        ], [
            'target_event.required' => 'Bitte eine Veranstaltung auswählen',
            'transaction.id.unique' => 'Buchung ist bereits der Veranstaltung zugeordnnet worden',
        ]);

        $event = Event::findOrFail($this->target_event);

        if (AppendEventTransaction::handle($this->transaction, $event, $this->event_visitor_name, $this->event_gender)) {
            Flux::toast(
                text: 'Die Buchung wurde erfolgreich zugeordnet',
                heading: __('transaction.attach-event-success.heading'),
                variant: 'success',
            );
            Flux::modal('append-to-event-transaction')
                ->close();
        }
    }

    public function appendMember(): void
    {
        $this->checkUser();
        $this->validate([
            'transaction.id' => ['unique:member_transactions,transaction_id'],
            'target_member' => 'required',
        ], [
            'target_member.required' => 'Bitte ein Mitglied auswählen',
            'transaction.id.unique' => 'Buchung ist bereits einem Mitglied zugeordnnet worden',
        ]);

        $member = Member::findOrFail($this->target_member);

        AppendMemberTransaction::handle($this->transaction, $member);
        Flux::toast(
            text: 'Die Buchung wurde erfolgreich zugeordnet',
            heading: __('transaction.detach-event-success.heading'),
            variant: 'success',
        );
        Flux::modal('append-to-member-transaction')
            ->close();
    }

    protected function checkUser(): void
    {
        try {
            $this->authorize('create', Transaction::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: __('transaction.access.denied').$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }
    }

    public function editTransactionText(int $transaction_id): void
    {
        $this->transaction = Transaction::findOrFail($transaction_id);

        $this->changeTextLabel = $this->transaction->label;
        $this->changeTextReference = $this->transaction->reference;
        $this->changeTextDescription = $this->transaction->description;

        Flux::modal('edit-transaction-text')
            ->show();
    }

    public function changeTransactionText(): void
    {
        $this->checkUser();

        if ($this->transaction->update([
            'label' => $this->changeTextLabel,
            'reference' => $this->changeTextReference,
            'description' => $this->changeTextDescription,
        ])) {
            Flux::toast(
                text: __('transaction.edit-text-modal.update-success.text'),
                heading: __('transaction.edit-text-modal.update-success.heading'),
                variant: 'success',
            );
            Flux::modal('edit-transaction-text')
                ->close();
        }
    }

    public function render()
    {
        return view('livewire.accounting.transaction.index.page');
    }
}
