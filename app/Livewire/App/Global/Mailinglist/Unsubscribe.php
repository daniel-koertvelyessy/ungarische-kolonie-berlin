<?php

namespace App\Livewire\App\Global\Mailinglist;

use App\Models\MailingList;
use App\View\Components\GuestLayout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Unsubscribe extends Component
{
    public $token;

    public $is_deleted;

    public $mailingList;

    public $update_on_events;

    public $update_on_articles;

    public $update_on_notifications;

    public function mount($token): void
    {
        $this->token = $token;

        try {

            $subscriber = MailingList::where('verification_token', $token)->firstOrFail();

            app()->setLocale($subscriber->locale->value);

            $this->is_deleted = $subscriber->delete();

        } catch (ModelNotFoundException $exception) {
            Log::alert('provided token not found ', ['msg' => $exception->getMessage(), 'token' => $token]);
            $this->redirect(route('home'), true);
        }
    }

    #[Layout(GuestLayout::class)]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.global.mailinglist.unsubscribe');
    }
}
