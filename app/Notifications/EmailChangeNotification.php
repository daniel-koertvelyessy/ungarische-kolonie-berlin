<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class EmailChangeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $oldEmail, public string $newEmail) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $rollbackUrl = url('/rollback-email?token='.encrypt($notifiable->id.'|'.$this->oldEmail));

        return (new MailMessage)
            ->subject('Deine E-Mail wurde geändert')
            ->line('Deine E-Mail wurde von '.$this->oldEmail.' zu '.$this->newEmail.' geändert.')
            ->line('Falls dies ein Fehler war, klicke unten, um zurückzusetzen:')
            ->action('Zurücksetzen', $rollbackUrl)
            ->line('Ignoriere diese Nachricht, wenn alles korrekt ist.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
