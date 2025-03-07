<?php

namespace App\Livewire\Accounting\Index;

use App\Enums\TransactionStatus;
use App\Livewire\Traits\Sortable;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use Sortable, WithPagination;



    protected $listeners = ['receipt-deleted' => '$refresh'];

    #[Computed]
    public function transactions(): LengthAwarePaginator
    {
        return Transaction::query()
            ->whereYear('date', session('financialYear'))
            ->where('status', '=', TransactionStatus::booked->value)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Computed]
    public function accounts(): LengthAwarePaginator
    {
        return Account::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.accounting.index.page');
    }
}
