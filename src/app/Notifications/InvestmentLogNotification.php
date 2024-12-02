<?php

namespace App\Notifications;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Payment\NotificationType;
use App\Jobs\EmailSmsProcessJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentLogNotification extends Notification
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
            'interest_rate' => $notifiable->interest_rate,
            'plan_name' => $notifiable->plan_name,
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

        $emailSMSTemplate = EmailSmsTemplateName::INVESTMENT_SCHEME_PURCHASE->value;
        $message = "Dear {$notifiable->user->full_name}, thank you for your investment! We're pleased to inform you that your transaction of {$currency}{$amount} for our investment plan has been processed. If you have any further questions, feel free to contact us. We appreciate your trust in our platform.";

        if ($this->notificationType->value == NotificationType::COMPLETE->value) {

            $emailSMSTemplate = EmailSmsTemplateName::INVESTMENT_COMPLETE->value;
            $message = "Dear {$notifiable->user->full_name}, your investment transaction of {$currency}{$amount} has been successfully completed. Charges: {$currency}{$charge}. Thank you for choosing our platform!";
        } elseif ($this->notificationType->value == NotificationType::RE_INVEST->value) {
            $emailSMSTemplate = EmailSmsTemplateName::RE_INVESTMENT->value;
            $message = "Dear {$notifiable->user->full_name}, congratulations on your re-investment! We're pleased to inform you that your request to re-invest {$currency}{$amount} has been successfully processed. If you have any further questions, feel free to contact us. Thank you for choosing our platform!";
        } elseif ($this->notificationType->value == NotificationType::CANCEL->value) {

            $rejectionReason = getArrayValue($notifiable->meta, '');
            $message = "Dear {$notifiable->user->full_name}, we regret to inform you that your investment plan of {$currency}{$amount} has been canceled. Please contact our support team for further assistance.";
            $emailSMSTemplate = EmailSmsTemplateName::INVESTMENT_CANCEL->value;
        }

        return [$emailSMSTemplate, $message];
    }

}
