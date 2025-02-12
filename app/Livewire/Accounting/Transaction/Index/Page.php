<?php

namespace App\Livewire\Accounting\Transaction\Index;

use App\Enums\DateRange;
use App\Enums\TransactionType;
use App\Livewire\Forms\ReceiptForm;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Account;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Livewire\Attributes\Url;
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
    public array $filter_status = ['eingereicht','gebucht'];
    public array $filter_type = [];
    public $selectedTransactions = [];
    public $numTransactions;
    public $transactionsOnPage = [];
    public $allTransactions = [];
    public $filter_date_range = DateRange::All->value;

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
            ->with('receipt')
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
            ->download($filePath);
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

    public function generatePreview()
    {
        $pdfFullPath = storage_path('app/'.$this->pdfPath);
        $outputPath = 'accounting/previews/'.pathinfo($this->pdfPath, PATHINFO_FILENAME).'.jpg';
        $outputFullPath = storage_path('app/'.$outputPath);

        if (!file_exists($outputFullPath)) {
            $imagick = new Imagick();
            $imagick->setResolution(150, 150); // Set DPI for better quality
            $imagick->readImage($pdfFullPath.'[0]'); // Read first page
            $imagick->setImageFormat('jpeg');
            $imagick->writeImage($outputFullPath);
            $imagick->clear();
            $imagick->destroy();
        }

        $this->previewImagePath = Storage::url($outputPath);
    }

    public function render()
    {
        return view('livewire.accounting.transaction.index.page');
    }
}
