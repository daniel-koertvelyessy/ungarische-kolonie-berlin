<?php

namespace App\Livewire\Accounting\Index;

use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
use WithPagination;

    public $sortBy = 'date';
    public $sortDirection = 'desc';

    protected $listeners = ['receipt-deleted' => '$refresh'];

    #[Computed]
    public function transactions()
    {
        return Transaction::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Computed]
    public function accounts(){
        return Account::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }


    public function render()
    {
        return view('livewire.accounting.index.page');
    }
}
