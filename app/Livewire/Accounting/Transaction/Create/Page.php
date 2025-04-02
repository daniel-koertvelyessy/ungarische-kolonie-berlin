<?php

namespace App\Livewire\Accounting\Transaction\Create;

use Livewire\Component;

class Page extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.transaction.create.page')
            ->title(__('transaction.create.title'));
    }
}
