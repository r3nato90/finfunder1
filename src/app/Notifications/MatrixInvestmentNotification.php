<?php

namespace App\Notifications;

use App\Enums\Email\EmailSmsTemplateName;
use App\Jobs\EmailSmsProcessJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MatrixInvestmentNotification extends Notification implements ShouldQueue
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $amount =  shortAmount($notifiable->amount);
        $currency = getCurrencySymbol();

        dispatch(new EmailSmsProcessJob($notifiable->user, [
            'amount' => $amount,
            'referral_commission' => $notifiable->referral_reward,
            'plan_name' => $notifiable->name,
            'currency' => getCurrencySymbol(),
        ], EmailSmsTemplateName::MATRIX_ENROLLED->value));

        return [
            'message' => "Dear {$notifiable->user->full_name}, thank you for enrolling in our matrix plan! Your transaction of {$currency}{$amount} was successful. If you have any questions, feel free to contact us. We appreciate your trust.",
            'url' => route('admin.matrix.enrol'),
            'name' => $notifiable->user->full_name,
        ];
    }
}
