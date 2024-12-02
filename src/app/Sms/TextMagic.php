<?php

namespace App\Sms;
use ErrorException;
use Textmagic\Services\TextmagicRestClient;

class TextMagic implements SmsGateway{

    /**
     * @param array $credential
     * @param string $number
     * @param string $message
     * @return void
     * @throws ErrorException
     */
    public function send(array $credential, string $number, string $message): void
    {
        $client = new TextmagicRestClient(getArrayValue($credential, 'text_magic_username'), getArrayValue($credential, 'api_key'));
        try {
            $result = $client->messages->create(
                array(
                    'text' => $message,
                    'phones' => $number,
                )
            );
        }
        catch (\Exception $e) {
        }
    }
}
