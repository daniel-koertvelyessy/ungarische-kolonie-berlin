<?php

namespace App\Livewire\App\Global;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsMenu extends Component
{
    public $notifications;

    protected $listeners = ['notificationReceived' => 'loadNotifications'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function markAsRead($notificationId): void
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.app.global.notifications-menu');
    }
}
