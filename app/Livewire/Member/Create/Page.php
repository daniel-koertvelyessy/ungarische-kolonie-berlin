<?php

declare(strict_types=1);

namespace App\Livewire\Member\Create;

use Livewire\Component;

final class Page extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.create.page');
    }
}
