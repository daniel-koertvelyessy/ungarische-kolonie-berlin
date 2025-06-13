<?php

declare(strict_types=1);

namespace App\Http\Resources\v1\Event;

use App\Enums\Locale;
use App\Models\Event\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        /** @var Event $event */
        $event = $this->resource;

        return [
            'title' => $event->title,
            'slug' => $event->slug,
            'excerpt' => $event->excerpt,
            'description' => $event->description,
            'event_date' => $event->event_date?->toDateString(),
            'start_time' => $event->start_time?->format('H:i'),
            'end_time' => $event->end_time?->format('H:i'),
            'image' => $event->image ? asset('storage/'.$event->image) : null,
            'entry_fee' => $event->entry_fee,
            'venue' => $event->venue ? [
                'name' => $event->venue->name,
                'address' => $event->venue->address,
                'city' => $event->venue->city,
                'website' => $event->venue->website,
                // Add other venue details as needed
            ] : null,
            'links' => [
                Locale::HU->value => route('events.show', ['slug' => $event->slug[Locale::HU->value] ?? null]),
                Locale::DE->value => route('events.show', ['slug' => $event->slug[Locale::DE->value] ?? null]),
            ],
        ];
    }
}
