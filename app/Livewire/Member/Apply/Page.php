<?php

declare(strict_types=1);

namespace App\Livewire\Member\Apply;

use Livewire\Attributes\Layout;
use Livewire\Component;

final class Page extends Component
{
    #[Layout('layouts.guest')]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.apply.page')->title(__('welcome.members.apply.header'));
    }
}
