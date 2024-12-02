<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Mail\GlobalMail;
use App\Models\Agent;
use App\Models\Setting;
use App\Models\SmsGateway;
use App\Models\User;
use App\Services\SettingService;
use App\Sms\MessageBird;
use App\Sms\TextMagic;
use App\Sms\TwilioSms;
use ErrorException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailSmsProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected User|Agent $user, protected array $replacer, protected string $code){
    }

    /**
     * Execute the job.
     * @return void
     * @throws ErrorException
     */
    public function handle(): void
    {
        $setting = SettingService::getSetting();
        $mailContent = mail_content($this->code);

        if (getArrayValue($setting->system_configuration, 'sms_notification.value') == Status::ACTIVE->value) {
            $this->sendSms($mailContent, $setting);
        }

        if (getArrayValue($setting->system_configuration, 'email_notification.value') == Status::ACTIVE->value) {
            $this->sendEmail($mailContent);
        }
    }


    protected function sendEmail(array $mailContent): void
    {
        $subject = getArrayValue($mailContent,'subject');
        $content = text_replacer(
            getArrayValue($mailContent,'email_content'),
            $this->replacer
        );

        Mail::to($this->user->email)->send(new GlobalMail($subject,$content));
    }

    /**
     * @throws ErrorException
     */
    protected function sendSms(array $mailContent, Setting $setting): void
    {
        $smsGateway = SmsGateway::where('id', $setting->sms_gateway_id)->first();

        if(!$smsGateway){
            return ;
        }

        $gateway = match ($smsGateway->code) {
            'TWILIO102' => new TwilioSms(),
            'IMESSAGE103' => new MessageBird(),
            'MAGIC104' => new TextMagic(),
            default => throw new Exception("Unknown SMS gateway code: {$smsGateway->code}"),
        };

        if ($this->user->phone) {
            $gateway->send(
                $smsGateway->credential,
                $this->user->phone,
                text_replacer(getArrayValue($mailContent,'sms_content'),$this->replacer)
            );
        }
    }

}
