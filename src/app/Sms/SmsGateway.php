<?php

namespace App\Sms;

interface SmsGateway
{
    public function send(array $credential, string $number, string $message);
}
