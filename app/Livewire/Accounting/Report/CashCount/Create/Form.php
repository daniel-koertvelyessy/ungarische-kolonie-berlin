<?php

namespace App\Livewire\Accounting\Report\CashCount\Create;

use App\Livewire\Accounting\Index\Page;
use App\Livewire\Forms\Accounting\CashCountForm;
use App\Livewire\Traits\HasPrivileges;
use App\Models\Accounting\Account;
use Carbon\Carbon;
use Flux\Flux;
use Livewire\Component;

class Form extends Component
{
    use HasPrivileges;

    public CashCountForm $form;

    public $accountId;

    public function mount(int $accountId)
    {
        $this->form->account_id = $accountId;
        $this->form->user_id = auth()->id();
        $this->form->counted_at = Carbon::today()->format('Y-m-d');
    }

    public function store()
    {
        $this->checkPrivilege(Account::class);
        $this->form->create();
        Flux::toast('Zählung erfasst!');
        $this->redirect(Page::class);
    }

    public function render()
    {
        return view('livewire.accounting.report.cash-count.create.form');
    }
}
