<?php

namespace App\Livewire\Accounting\Transaction\Index;

use App\Actions\Accounting\CreateEventTransaction;
use App\Actions\Accounting\CreateMemberTransaction;
use App\Enums\DateRange;
use App\Enums\Gender;
use App\Enums\MemberType;
use App\Enums\TransactionType;
use App\Livewire\Forms\ReceiptForm;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use App\Models\Event;
use App\Models\Membership\Member;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Imagick;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Page extends Component
{

    use \Livewire\WithPagination;

    protected $listeners = ['transaction-updated'];
    public ReceiptForm $receipt;
    public ?Transaction $transaction = null;

    public $sortBy = 'date';
    public $sortDirection = 'desc';

    public $search;
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
            ->map(fn($transaction) => (string) $transaction->id)
            ->toArray();

        $date_range = DateRange::from($this->filter_date_range)
            ->dates();

        $transactionList = \App\Models\Accounting\Transaction::query()
            ->with('event_transaction')
            ->with('member_transaction')
            ->tap(fn($query) => $this->search ? $query->where('label', 'LIKE', '%'.$this->search.'%') : $query)
            ->whereIn('status', $this->filter_status)
            ->whereIn('type', $this->filter_type)
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn($query) => $this->filter_date_range === DateRange::All->value ? $query : $query->whereBetween('date', $date_range))
//            ->tap(fn($query) => logger()->info($query->toSql(), $query->getBindings()))
            ->paginate(15)
            ->through(fn($transaction) => $transaction->refresh());

        $this->transactionsOnPage = $transactionList->map(fn($transaction) => (string) $transaction->id)
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
        if (!Storage::disk('local')
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

    public function cancelItem(int $transaction_id)
    {
        dd($transaction_id);
    }

    public function appendToEvent(int $transactioId): void
    {
        try {
            $this->authorize('create', Transaction::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: 'Sie haben keine Berechtigungen Buchungen zu verwalten: '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );
            return;
        }

        $this->transaction = Transaction::findOrFail($transactioId);
        Flux::modal('append-to-event-transaction')
            ->show();
    }

    public function appendToMember(int $transactioId): void
    {
        try {
            $this->authorize('create', Transaction::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: 'Sie haben keine Berechtigungen Buchungen zu verwalten: '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );
            return;
        }

        $this->transaction = Transaction::findOrFail($transactioId);
        Flux::modal('append-to-member-transaction')
            ->show();
    }

    public function appendEvent(): void
    {
        $this->checkUser();
        $this->validate([
            'transaction.id'       => ['unique:event_transactions,transaction_id'],
            'target_event' => 'required',
            'event_visitor_name' => '',
            'event_gender'       => ['nullable', Rule::enum(Gender::class)]
        ], [
            'target_event.required'        => 'Bitte eine Veranstaltung auswählen',
            'transaction.id.unique' => 'Buchung ist bereits der Veranstaltung zugeordnnet worden',
        ]);

        $event = Event::findOrFail($this->target_event);

        if (CreateEventTransaction::handle($this->transaction, $event, $this->event_visitor_name, $this->event_gender)) {
            Flux::toast(
                text: 'Die Buchung wurde erfolgreich zugeordnet',
                heading: 'Erfolg',
                variant: 'sucess',
            );
            Flux::modal('append-to-event-transaction')
                ->close();
        }
    }

    public function appendMember(): void
    {
        $this->checkUser();
        $this->validate([
            'transaction.id'       => ['unique:member_transactions,transaction_id'],
            'target_member' => 'required'
        ], [
            'target_member.required'         => 'Bitte ein Mitglied auswählen',
            'transaction.id.unique' => 'Buchung ist bereits einem Mitglied zugeordnnet worden',
        ]);

        $member = Member::findOrFail($this->target_member);

        CreateMemberTransaction::handle($this->transaction, $member);
            Flux::toast(
                text: 'Die Buchung wurde erfolgreich zugeordnet',
                heading: 'Erfolg',
                variant: 'sucess',
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
                text: 'Sie haben keine Berechtigungen zur Erstellung von Konten'.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );
            return;
        }
    }

    public function render()
    {
        return view('livewire.accounting.transaction.index.page');
    }
}
