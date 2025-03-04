<?php

namespace App\Livewire\Forms;

use App\Actions\Event\CreateEvent;
use App\Enums\EventStatus;
use App\Enums\Locale;
use App\Models\Event\Event;
use App\Rules\UniqueJsonSlug;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventForm extends Form
{
    public Event $event;

    public string $locale;

    public array $locales;

    public $status = EventStatus::DRAFT->value;

    public $name;

    public $id;

    public $event_date;

    public $start_time;

    public $end_time;

    public $image;

    public $entry_fee;

    public $entry_fee_discounted;

    public $payment_link;

    public array $title;

    #[Validate]
    public array $slug;

    public array $excerpt;

    public array $description;

    public $venue_id;

    public function setEvent(Event $event): void
    {
        $this->event = $event;
        $this->locale = session('locale') ?? app()->getLocale();
        $this->locales = Locale::cases();
        $this->name = $this->event->name;
        $this->event_date = $this->event->event_date->format('Y-m-d');
        $this->id = $this->event->id;
        $this->start_time = $this->event->start_time->format('H:i');
        $this->end_time = $this->event->end_time->format('H:i');
        $this->status = $this->event->status;
        $this->title = $this->event->title;
        $this->excerpt = $this->event->excerpt;
        $this->slug = $this->event->slug;
        $this->payment_link = $this->event->payment_link;
        $this->description = $this->event->description;
        $this->entry_fee = $this->event->entry_fee;
        $this->entry_fee_discounted = $this->event->entry_fee_discounted;
        $this->venue_id = $this->event->venue_id;
    }

    public function create(): Event
    {
        $this->validate();

        return CreateEvent::handle($this);
    }

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'venue_id' => 'nullable|exists:venues,id',
            'event_date' => 'nullable|date',
            'start_time' => 'required_with:event_date',
            'end_time' => 'required_with:event_date',
            'title.*' => [  // Using wildcard for each locale key
                'required',
                new UniqueJsonSlug('events', 'title', $this->id),
            ],
            'slug.*' => new UniqueJsonSlug('events', 'slug', $this->id),
            'excerpt' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable',
            'payment_link' => 'nullable',
            'status' => ['nullable', Rule::enum(EventStatus::class)],
            'entry_fee' => 'nullable|numeric',
            'entry_fee_discounted' => 'nullable|numeric',
        ];
    }

    public function update()
    {
        $this->validate();
        $this->event->event_date = $this->event_date;
        $this->event->start_time = $this->start_time;
        $this->event->end_time = $this->end_time;
        $this->event->title = $this->title;
        $this->event->excerpt = $this->excerpt;
        $this->event->slug = $this->slug;
        $this->event->description = $this->description;
        $this->event->entry_fee = $this->entry_fee;
        $this->event->entry_fee_discounted = $this->entry_fee_discounted;
        $this->event->venue_id = $this->venue_id;
        $this->event->payment_link = $this->payment_link;
        $this->event->status = $this->status;
        $this->event->name = $this->name;

        if ($this->event->save()) {
            Flux::toast(
                text: __('event.update.success.content'),
                heading: __('event.update.success.title'),
                variant: 'success',
            );
        }
    }

    public function storeImage($file): bool
    {
        $this->event->image = $file;

        return $this->event->save();
    }

    public function deleteImage(): bool
    {
        try {
            $del = Storage::disk('public')
                ->delete('/image/images/'.$this->event->image);
            if ($del) {
                $this->event->image = null;

                return $this->event->save();
            }
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            Flux::toast(
                text: 'Die Datei konnte nicht gelköscht werden => '.$e->getMessage(),
                heading: 'Fehler',
                variant: 'danger',
            );
        }

        return false;
    }
}
