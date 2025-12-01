<?php

declare(strict_types=1);

namespace App\Livewire\Member\Apply;

use Livewire\Attributes\Layout;
use Livewire\Component;

final class Page extends Component
{
    public bool $isExternalMemberApplication = true;

    #[Layout('layouts.guest')]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.apply.page', ['isExternalMemberApplication' => $this->isExternalMemberApplication])->title(__('welcome.members.apply.header'));
    }
}
