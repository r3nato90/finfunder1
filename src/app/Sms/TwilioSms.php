<?php

namespace App\Sms;
use Illuminate\Support\Arr;
use Twilio\Rest\Client;

class TwilioSms implements SmsGateway{

    public function send(array $credential, string $number, string $message): void
    {
        try{
            $client = new Client(Arr::get($credential, 'account_sid'), Arr::get($credential, 'auth_token', ''));
            $client->messages->create($number,
                [
                    'from' =>  Arr::get($credential, 'from_number'),
                    'body' => $message
                ]
            );
        }catch (\Exception $e) {
        }
    }
}
