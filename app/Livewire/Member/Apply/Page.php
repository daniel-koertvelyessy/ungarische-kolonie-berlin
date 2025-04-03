<?php

namespace App\Livewire\Member\Apply;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Page extends Component
{
    #[Layout('layouts.guest')]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.apply.page')->title(__('welcome.members.apply.header'));
    }
}
