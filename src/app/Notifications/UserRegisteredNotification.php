<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRegisteredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @param object $notifiable
     * @return array
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "New member {$notifiable->fullname} registered! Welcome to our community. We're excited to have you on board!",
            'url' => route('admin.user.details', $notifiable->id),
            'name' => $notifiable->full_name,
        ];
    }
}
