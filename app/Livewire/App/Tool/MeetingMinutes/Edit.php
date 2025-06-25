<?php

namespace App\Livewire\App\Tool\MeetingMinutes;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('livewire.app.tool.meeting-minutes.edit')
            ->title(__('minutes.edit.page_title'));
    }
}
