<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\MeetingMinutes;

use App\Livewire\Forms\Minutes\MeetingMinuteForm;
use App\Models\MeetingMinute;
use Livewire\Component;

final class Edit extends Component
{
    public MeetingMinute $meetingMinute;

    public MeetingMinuteForm $minuteForm;

    public function mount(MeetingMinute $meetingMinute)
    {
        $this->meetingMinute = $meetingMinute;
    }

    public function render()
    {
        return view('livewire.app.tool.meeting-minutes.edit')
            ->title(__('minutes.edit.page_title'));
    }
}
