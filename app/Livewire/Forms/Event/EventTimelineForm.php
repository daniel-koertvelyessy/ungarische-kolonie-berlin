<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Event;

use App\Actions\Event\CreateTimeline;
use App\Actions\Event\UpdateTimeline;
use App\Models\EventTimeline;
use Livewire\Form;

class EventTimelineForm extends Form
{
    public EventTimeline $eventTimeline;

    public $start;

    public $duration;

    public $end;

    public $event_id;

    public $title;

    public array $title_extern;

    public $description;

    public $notes;

    public $member_id;

    public $user_id;

    public $id;

    public $place;

    public $performer;

    public function set(EventTimeline $eventTimeline): void
    {
        $this->start = $eventTimeline->start;
        $this->duration = $eventTimeline->duration;
        $this->end = $eventTimeline->end;
        $this->event_id = $eventTimeline->event_id;
        $this->title = $eventTimeline->title;
        $this->description = $eventTimeline->description;
        $this->notes = $eventTimeline->notes;
        $this->member_id = $eventTimeline->member_id;
        $this->user_id = $eventTimeline->user_id;
        $this->place = $eventTimeline->place;
        $this->performer = $eventTimeline->performer;
        $this->id = $eventTimeline->id;
        $this->title_extern = $eventTimeline->title_extern ?? [];
    }

    public function create(): void
    {
        $this->validate();
        CreateTimeline::handle($this);

    }

    public function update(): void
    {
        $this->validate();
        UpdateTimeline::handle($this);
    }

    protected function rules(): array
    {
        return [
            'start' => ['required', 'date_format:H:i'],
            'duration' => ['nullable'],
            'end' => 'required|after:start',
            'event_id' => 'required|exists:events,id',
            'title' => 'required',
            'description' => 'string|nullable',
            'notes' => 'string|nullable',
            'place' => 'string|nullable',
            'performer' => 'string|nullable',
            'member_id' => 'nullable|exists:members,id',
            'user_id' => 'required|nullable|exists:users,id',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => __('timeline.validation_error.title.required'),
            'start.required' => __('timeline.validation_error.start.required'),
            'end.required' => __('timeline.validation_error.end.required'),
            'end.after' => __('timeline.validation_error.end.after'),
            'event_id.required' => __('timeline.validation_error.event_id.required'),
            'user_id.required' => __('timeline.validation_error.user_id.required'),
        ];
    }
}
