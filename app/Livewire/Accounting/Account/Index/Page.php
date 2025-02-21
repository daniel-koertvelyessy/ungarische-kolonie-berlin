<?php

namespace App\Livewire\Accounting\Account\Index;

use App\Enums\TransactionStatus;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;

    public Account $account;

    public $sortBy = 'date';

    public $sortDirection = 'desc';

    public $selectedAccount;

    protected $listeners = ['account-updated' => '$refresh'];

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function accounts(): LengthAwarePaginator
    {
        return Account::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Computed]
    public function transactions(): LengthAwarePaginator
    {
        return Transaction::query()
            ->where('account_id', $this->account->id)
            ->where('status', '=', TransactionStatus::booked->value)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function editAccount(): void
    {
        $this->account = Account::find($this->selectedAccount);

    }

    public function render()
    {
        return view('livewire.accounting.account.index.page');
    }
}
