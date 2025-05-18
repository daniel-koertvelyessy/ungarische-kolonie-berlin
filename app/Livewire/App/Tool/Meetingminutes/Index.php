<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\Meetingminutes;

use App\Livewire\Traits\Sortable;
use App\Models\MeetingMinute;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    use Sortable;

    #[Computed]
    public function minutes(): LengthAwarePaginator
    {
        return MeetingMinute::query()->orderByDesc('meeting_date')->paginate(10);
    }

    public function render()
    {
        return view('livewire.app.tool.meeting-minutes.index')
            ->title(__('minutes.index.page_title'));
    }
}
