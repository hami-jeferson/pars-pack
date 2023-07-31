<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $appName;
    protected $subscribeEmail;
    protected $expiredCount;

    public function __construct(string $appName, string $subscribeEmail)
    {
        $this->appName = $appName;
        $this->subscribeEmail = $subscribeEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Status Changed')
            ->line("The subscription status in app '{$this->appName}' for subscribe with email '{$this->subscribeEmail}' has changed.");
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
