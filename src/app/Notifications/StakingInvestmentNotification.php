<?php

namespace App\Notifications;

use App\Enums\Email\EmailSmsTemplateName;
use App\Jobs\EmailSmsProcessJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StakingInvestmentNotification extends Notification
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

    public function toArray(object $notifiable): array
    {
        $currency = getCurrencySymbol();
        $amount = $notifiable->amount;

        dispatch(new EmailSmsProcessJob($notifiable->user, [
            'amount' => $amount,
            'interest' => $notifiable->interest,
            'expiration_date' => $notifiable->expiration_date,
            'currency' => $currency,
        ], EmailSmsTemplateName::STAKING_INVESTMENT_NOTIFY->value));

        return [
            'message' => "Dear {$notifiable->user->full_name}, thank you for investing {$currency}{$amount} in our staking plan! Your transaction has been processed. For questions, contact us. We appreciate your trust.",
            'url' => route('admin.binary.staking.investment'),
            'name' => $notifiable->user->full_name,
        ];
    }
}
