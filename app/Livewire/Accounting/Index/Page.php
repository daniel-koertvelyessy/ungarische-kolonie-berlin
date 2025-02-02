<?php

namespace App\Livewire\Accounting\Index;

use Livewire\Attributes\Computed;
use Livewire\Component;

class Page extends Component
{

    public array $receipts=[];
    public array $accounts=[];
    #[Computed]
    public function receipts(){

    }

    #[Computed]
    public function accounts(){

    }


    public function render()
    {
        return view('livewire.accounting.index.page');
    }
}
