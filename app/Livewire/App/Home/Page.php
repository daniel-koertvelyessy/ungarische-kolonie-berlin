<?php

namespace App\Livewire\App\Home;

use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Page extends Component
{
    public $events;
    public $events_total;
    public $posts;
    public $posts_count;


    public function mount(int $takes = 3): void
    {
        $this->events = \App\Models\Event\Event::query()
            ->with('venue')
            ->where('status', '=', \App\Enums\EventStatus::PUBLISHED)
            ->whereBetween('event_date', [
                Carbon::today('Europe/Berlin'), Carbon::now('Europe/Berlin')
                    ->endOfYear()
            ])
            ->take($takes)
            ->get();

        $this->events_total = $this->events->count();

        $this->posts = \App\Models\Blog\Post::query()
            ->where('posts.status', \App\Enums\EventStatus::PUBLISHED->value)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        $this->posts_count = $this->posts->count();
    }


    #[Layout('layouts.guest')]
    public function render(): View
    {
        return view('livewire.app.home.page');
    }
}
