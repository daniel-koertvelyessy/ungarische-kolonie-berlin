<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMemberApplied extends Notification //implements ShouldQueue
{
    // use Queueable;

    protected $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member)
    {

        $this->member = $member;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $url = route('dashboard');

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your invoices has been paid!')
            ->lineIf($this->member->email === null, "E-Mail: {$this->member->email}")
            ->action('View Invoice', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'applied_at' => $this->member->applied_at,
            'fullName' => $this->member->name . ', ' . $this->member->first_name
        ];
    }
}
