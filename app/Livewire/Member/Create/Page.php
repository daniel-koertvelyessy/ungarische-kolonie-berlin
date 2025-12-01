<?php

declare(strict_types=1);

namespace App\Livewire\Member\Create;

use Livewire\Component;

final class Page extends Component
{
    public bool $isExternalMemberApplication = false;

    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.create.page', ['isExternalMemberApplication' => $this->isExternalMemberApplication])->title(__('members.create.title'));
    }
}
