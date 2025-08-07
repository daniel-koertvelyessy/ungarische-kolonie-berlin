<?php

declare(strict_types=1);

namespace App\Livewire\Accounting\Report\Create;

use Livewire\Component;

final class Page extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.report.create.page');
    }
}
