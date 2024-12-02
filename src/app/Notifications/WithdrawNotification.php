<?php

namespace App\Notifications;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Payment\NotificationType;
use App\Jobs\EmailSmsProcessJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class WithdrawNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
    public function __construct(protected NotificationType $notificationType)
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
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        [$amount, $charge, $currency] = $this->getData($notifiable);
        [$emailSMSTemplate, $message] = $this->getNotification($notifiable);

        dispatch(new EmailSmsProcessJob($notifiable->user, [
            'amount' => $amount,
            'charge' => $charge,
            'currency' => $currency,
        ], $emailSMSTemplate));

        return [
            'message' => $message,
            'url' => route('admin.withdraw.details', $notifiable->id),
            'name' => $notifiable->user->full_name,
        ];
    }


    protected function getData(object $notifiable): array
    {
        $amount = shortAmount($notifiable->amount);
        $charge = shortAmount($notifiable->charge);
        $currency = getCurrencySymbol();

        return [$amount, $charge, $currency];
    }

    protected function getNotification(object $notifiable): array
    {
        [$amount, $charge, $currency] = $this->getData($notifiable);

        $emailSMSTemplate = EmailSmsTemplateName::WITHDRAW_REQUEST->value;
        $message = "Dear {$notifiable->user->full_name}, we've received your withdrawal request of {$currency}{$amount}. It's currently in process and awaiting approval. Contact us for any questions. Thank you.";

        if ($this->notificationType->value == NotificationType::APPROVED->value){
            $emailSMSTemplate = EmailSmsTemplateName::WITHDRAW_APPROVED->value;
            $message = "Dear {$notifiable->user->full_name}, your withdrawal of {$currency}{$amount} has been successfully processed. Charges: {$currency}{$charge}. Thank you for choosing our platform!";

        } elseif ($this->notificationType->value == NotificationType::REJECTED->value) {

            $rejectionReason =  getArrayValue($notifiable->meta, '');
            $message = "Dear {$notifiable->user->full_name}, we regret to inform you that your withdrawal request of {$currency}{$amount} has been rejected. Reason: {$rejectionReason}. If you have any questions, please contact our support team.";
            $emailSMSTemplate = EmailSmsTemplateName::WITHDRAW_REJECTED->value;
        }

        return [$emailSMSTemplate,$message];
    }
}
