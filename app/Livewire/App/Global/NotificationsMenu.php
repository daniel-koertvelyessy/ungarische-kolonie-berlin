<?php

declare(strict_types=1);

namespace App\Livewire\App\Global;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class NotificationsMenu extends Component
{
    public Collection $notifications;

    protected $listeners = ['notificationReceived' => 'loadNotifications'];

    public function mount(): void
    {
        $this->notifications = new Collection;
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $this->notifications = new Collection(Auth::user()->unreadNotifications);
    }

    public function markAsRead($notificationId): void
    {
        if (! Auth::check()) {
            return;
        }

        $notification = Auth::user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }

        $this->loadNotifications();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.global.notifications-menu');
    }
}
