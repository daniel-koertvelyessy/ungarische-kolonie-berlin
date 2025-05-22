<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\Meetingminutes;

use App\Livewire\Traits\Sortable;
use App\Models\MeetingMinute;
use App\Services\PdfGeneratorService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use Sortable;
    use WithPagination;

    public string $search = '';

    public ?MeetingMinute $selectedMeeting = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function minutes(): LengthAwarePaginator
    {
        $query = MeetingMinute::query()->with(['attendees', 'topics:id,content', 'actionItems'])
            ->join('meeting_topics', 'meeting_topics.meeting_id', '=', 'meeting_minutes.id');

        if ($this->sortBy) {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        if ($this->search) {
            $query->where('title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('meeting_topics.content', 'LIKE', '%'.$this->search.'%');
        }

        return $query->paginate(10);

    }

    public function render(): View
    {
        return view('livewire.app.tool.meeting-minutes.index')
            ->title(__('minutes.index.page_title'));
    }

    public function fetchMeetingMinutes(int $meetingId): void
    {
        $this->authorize('view', MeetingMinute::class);
        $this->selectedMeeting = MeetingMinute::with(['attendees', 'topics.topicActionItems.assignee'])
            ->findOrFail($meetingId);
    }

    public function editMeetingMinutes(int $meetingId): void
    {
        // TODO: Redirect to edit page
        $this->authorize('update', MeetingMinute::findOrFail($meetingId));
        $this->redirect(route('minutes.edit', $meetingId), navigate: true);
    }

    /**
     * @return ResponseFactory|Application|Response|object|void
     */
    public function printMeetingMinutes(int $meetingId)
    {
        $meeting = MeetingMinute::findOrFail($meetingId);
        $this->authorize('view', $meeting);

        try {
            $pdfContent = PdfGeneratorService::generatePdf(
                type: 'meeting-minute',
                data: $meeting,
                restricted: true
            );

            $filename = "meeting-minute-{$meetingId}-".now()->format('Ymd').'.pdf';

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "inline; filename=\"{$filename}\"");
        } catch (\Exception $e) {
            \Log::error('Failed to generate meeting minute PDF', ['error' => $e->getMessage(), 'meeting_id' => $meetingId, 'meeting' => $meeting, 'user_id' => auth()->id(), 'user_name' => auth()->user()->name ?? 'unknown user']);
            session()->flash('error', __('minutes.index.pdf_error'));
            $this->redirect(route('minutes.index'), navigate: true);
        }
    }
}
