<?php

namespace App\Livewire\Accounting\Receipt\Index;

use App\Models\Accounting\Receipt;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;

    #[Computed]
    public function receipts(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Receipt::latest()->paginate(10);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.receipt.index.page');
    }
}
