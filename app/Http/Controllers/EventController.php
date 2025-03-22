<?php

namespace App\Http\Controllers;

use App;
use App\Enums\EventStatus;
use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use App\Services\IcsGeneratorService;

class EventController extends Controller
{
    public function generateIcs(string $slug, IcsGeneratorService $service): \Illuminate\Http\Response
    {
        return $service->generate($slug);
    }

    public function index(int $numPages = 5): \Illuminate\View\View
    {
        return view('events.index', [
            'events' => Event::orderBy('event_date')
                ->where('status', '=', EventStatus::PUBLISHED->value)
                ->paginate($numPages),
            'locale' => App::getLocale(),
        ]);
    }

    public function show(string $slug): \Illuminate\View\View
    {
        $locale = App::getLocale();

        return view('events.show', [
            'event' => Event::query()
                ->with('venue')
                ->with('timelines')
                ->where("slug->{$locale}", $slug) // Match the slug for the specific locale
                ->firstOrFail(),
            'locale' => $locale,
        ]);
    }

    public function confirmSubscription(EventSubscription $eventSubscription, string $token)
    {
        $storedToken = cache()->get("event_subscription_{$eventSubscription->id}_token");

        if ($storedToken && $storedToken === $token) {
            $eventSubscription->update(['confirmed_at' => now()]);
            cache()->forget("event_subscription_{$eventSubscription->id}_token");

            session()->flash('status', 'Deine Anmeldung wurde bestätigt! 🎉');

            return view('events.show', ['event' => $eventSubscription->event, 'locale' => app()->getLocale()]);
        }

        abort(403);
    }
}
