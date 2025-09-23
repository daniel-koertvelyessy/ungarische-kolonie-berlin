<?php

declare(strict_types=1);

namespace App\Livewire\Accounting\Index;

use App\Enums\TransactionStatus;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\Sortable;
use App\Models\Accounting\Account;
use App\Models\Accounting\AccountReport;
use App\Models\Accounting\CashCount;
use App\Models\Accounting\Transaction;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

final class Page extends Component
{
    use HasPrivileges;
    use Sortable;
    use WithPagination;

    protected $listeners = ['receipt-deleted' => '$refresh'];

    public CashCount $selectedCashCount;

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

    #[Computed]
    public function reports(): LengthAwarePaginator
    {
        return AccountReport::query()
            ->whereYear('period_start', session('financialYear'))
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function initCashContDeletion(int $id): void
    {
        $this->checkPrivilege(Account::class);
        $this->selectedCashCount = CashCount::find($id);
        Flux::modal('delete-cash-count')->show();

    }

    public function deleteCashCount(): void
    {
        $this->checkPrivilege(Account::class);
        $this->selectedCashCount->delete();
        Flux::modal('delete-cash-count')->close();
        Flux::toast(
            text: __('account.cashcount.delete.confirmationtoast.txt'),
            variant: 'success');
    }

    public function editCashCount(int $id): void
    {
        $this->checkPrivilege(Account::class);
        $this->selectedCashCount = CashCount::find($id);
        Flux::modal('edit-cash-count')->show();

    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.index.page');
    }
}
