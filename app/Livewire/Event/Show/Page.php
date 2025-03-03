<?php

namespace App\Livewire\Event\Show;

use App\Enums\AssignmentStatus;
use App\Livewire\Forms\AssignmentForm;
use App\Livewire\Forms\EventForm;
use App\Livewire\Forms\EventTimelineForm;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\PersistsTabs;
use App\Livewire\Traits\Sortable;
use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use App\Models\EventAssignment;
use App\Models\EventTimeline;
use App\Models\Venue;
use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use HasPrivileges, PersistsTabs, Sortable, WithPagination;

    public EventForm $form;

    public AssignmentForm $assignmentForm;

    public EventTimelineForm $timelineForm;

    public $event_id;

    public Event $event;

    public $defaultTab = 'event-show-dates';

    public $selectedRow;

    public string $selectedTab;

    protected $listeners = [
        'updated-payments' => 'payments',
        'event-visitor-added' => 'visitors',
    ];

    #[Computed]
    public function subscriptions()
    {
        return EventSubscription::where('event_id', $this->event_id)
            ->paginate(10);
    }

    #[Computed]
    public function assignments()
    {
        return EventAssignment::where('event_id', $this->event_id)
            ->paginate(10);
    }

    #[Computed]
    public function venues()
    {
        return Venue::select('id', 'name')
            ->get();
    }

    #[Computed]
    public function payments(): LengthAwarePaginator
    {
        return EventTransaction::query()
            ->with('transaction')
            ->where('event_id', '=', $this->event_id)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Computed]
    public function visitors(): LengthAwarePaginator
    {
        return EventVisitor::query()
            ->with('member')
            ->where('event_id', '=', $this->event_id)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Computed]
    public function timelineItems(): LengthAwarePaginator
    {
        return EventTimeline::query()
            ->with('member')
            ->where('event_id', '=', $this->event_id)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function mount(Event $event): void
    {
        $this->event_id = $event->id;
        $this->form->setEvent($event);
        $this->selectedTab = $this->getSelectedTab();
        $this->assignmentForm->due_at = Carbon::today()
            ->format('Y-m-d');
        $this->assignmentForm->status = AssignmentStatus::draft->value;
        $this->assignmentForm->member_id = auth()->user()->member->id;
        $this->timelineForm->member_id = auth()->user()->member->id;
    }

    public function addVisitor(): void
    {
        $this->checkPrivilege(Event::class);
        Flux::modal('add-new-visitor')
            ->show();
    }

    public function updateEventData(): void
    {
        $this->checkPrivilege(Event::class);
        $this->form->update();
    }

    #[On('image-uploaded')]
    public function storeImage($file): void
    {
        if ($this->form->storeImage($file)) {
            Flux::toast(
                text: __('event.store_image.success.content'),
                heading: __('event.store_image.success.title'),
                variant: 'success',
            );
        } else {
            dd('fehler');
        }
    }

    #[On('new-venue-created')]
    public function assignVenue(): void {}

    public function deleteImage(): void
    {
        if ($this->form->deleteImage()) {
            Flux::toast(
                text: __('event.delete_image.success.content'),
                heading: __('event.delete_image.success.title'),
                variant: 'success',
            );
        } else {
            dd('fehler');
        }
    }

    public function generateEventReport() {}

    public function startNewAssigment(): void
    {
        $this->checkPrivilege(Event::class);

        $this->reset('assignmentForm');
        Flux::modal('assignment-modal')->show();
    }

    public function startNewTimelineItem(): void
    {
        $this->checkPrivilege(Event::class);

//        $this->reset('timelineForm');
        Flux::modal('timeline-modal')->show();
    }

    public function storeAssignment(): void
    {
        $this->checkPrivilege(Event::class);

        if ($this->assignmentForm->id) {
            $this->assignmentForm->update();
        } else {
            $this->assignmentForm->event_id = $this->event_id;
            $this->assignmentForm->user_id = auth()->user()->id;
            $this->assignmentForm->create();
            Flux::toast(
                text: __('assignment.storing_success.msg'),
                heading: __('assignment.storing_success.header'),
                variant: 'success',
            );
        }
    }

    public function editAssignment(int $assignmentId): void
    {
        $this->selectedRow = $assignmentId;
        $this->checkPrivilege(Event::class);
        $this->assignmentForm->set(EventAssignment::findOrFail($assignmentId));
        Flux::modal('assignment-modal')->show();
    }

    public function deleteAssignment(int $assignmentId): void
    {
        $this->checkPrivilege(Event::class);
        if (EventAssignment::find($assignmentId)->delete()) {
            Flux::toast(
                text: __('assignment.deletion_success.msg'),
                heading: __('assignment.deletion_success.header'),
                variant: 'success',
            );
        }
    }

    public function storeTimeline(): void
    {
        $this->checkPrivilege(Event::class);

        if ($this->timelineForm->id) {
            $this->timelineForm->update();
        } else {
            $this->timelineForm->event_id = $this->event_id;
            $this->timelineForm->user_id = auth()->user()->id;
            $this->timelineForm->create();
            $this->timelineForm->start = $this->timelineForm->end;
            $this->timelineForm->end = '';
        }
    }

    public function editTimeline(int $timelineId): void
    {
        $this->checkPrivilege(Event::class);
        $this->timelineForm->set(EventTimeline::findOrFail($timelineId));
        Flux::modal('timeline-modal')->show();
    }

    public function deleteTimeline(int $timelineId): void
    {
        $this->checkPrivilege(Event::class);
        if (EventTimeline::find($timelineId)->delete()) {
            Flux::toast(
                text: __('timeline.deletion_success.msg'),
                heading: __('timeline.deletion_success.header'),
                variant: 'success',
            );
        }
    }

    public function sendAssignmentNotification(int $assignmentId) {}

    public function render()
    {
        return view('livewire.event.show.page');
    }
}
