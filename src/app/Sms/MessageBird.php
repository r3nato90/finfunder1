<?php

namespace App\Sms;

class MessageBird implements SmsGateway{

    /**
     * @param array $credential
     * @param string $number
     * @param string $message
     * @return void
     */
    public function send(array $credential, string $number, string $message): void
    {
        try {
            $MessageBird = new \MessageBird\Client(getArrayValue($credential,'access_key'));
            $Message = new \MessageBird\Objects\Message();
            $Message->originator = getArrayValue($credential,'access_key');
            $Message->recipients = array($number);
            $Message->datacoding = 'plain';
            $Message->body 	= $message;
            $MessageBird->messages->create($Message);
        } catch (\Exception $e) {

        }
    }
}
