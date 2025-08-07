<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\MeetingMinutes;

use Illuminate\View\View;
use Livewire\Component;

final class Create extends Component
{
    public function render(): View
    {
        return view('livewire.app.tool.meeting-minutes.create')->title(__('minutes.create.page_title'));
    }
}
