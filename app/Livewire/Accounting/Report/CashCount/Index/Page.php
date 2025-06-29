<?php

declare(strict_types=1);

namespace App\Livewire\Accounting\Report\CashCount\Index;

use App\Livewire\Accounting\Report\CashCount\Create\Form;
use Livewire\Component;

class Page extends Component
{
    public function startNewCount(): void
    {
        $this->redirect(Form::class);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.report.cash-count.index.page');
    }
}
