<?php

namespace App\Http\Controllers;

use App;
use App\Enums\EventStatus;
use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use App\Services\IcsGeneratorService;
use Illuminate\Support\Facades\Log;

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
        $event = Event::query()
            ->with('venue')
            ->with('posts')
            ->with('timelines')
            ->where("slug->{$locale}", $slug) // Match the slug for the specific locale
            ->firstOrFail();
        $relatedPosts = $event->relatedPosts();
        $relatedPostsCount = $event->relatedPosts()
            ->count();

        return view('events.show', [
            'event' => $event,
            'locale' => $locale,
            'relatedPosts' => $relatedPosts,
            'relatedPostsCount' => $relatedPostsCount,
        ]);
    }

    public function confirmSubscription(int $eventSubscriptionId, string $token)
    {
        $storedToken = cache()->get("event_subscription_{$eventSubscriptionId}_token");

        //        Log::debug('compare tokens', ['token' => $token, 'eventSubscription' => $eventSubscriptionId, 'storedToken' => $storedToken]);

        if ($storedToken && $storedToken === $token) {

            $eventSubscription = EventSubscription::query()
                ->findOrFail($eventSubscriptionId);
            $eventSubscription->update(['confirmed_at' => now()]);
            session()->flash('status', 'Deine Anmeldung wurde bestätigt! 🎉');
            cache()->forget("event_subscription_{$eventSubscription->id}_token");

            return $this->show($eventSubscription->event->slug[app()->getLocale()]);
        }

        abort(403);
    }
}
