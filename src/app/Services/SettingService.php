<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class SettingService
{
    public static function getSetting()
    {
        try {
            return Setting::first();
        }catch (\Exception $exception){
            return null;
        }
    }

    /**
     * @return array
     */
    public static function getKycConfiguration(): array
    {
        return self::getSetting()->kyc_configuration;
    }

    public static function mail(): void
    {
        $setting = self::getSetting();
        $mailConfiguration = $setting->mail_configuration ?? null;

        Config::set('mail.mailers.smtp.host', getArrayValue($mailConfiguration, 'host', 'smtp.mailgun.org'));
        Config::set('mail.mailers.smtp.port',  getArrayValue($mailConfiguration, 'port', '587'));
        Config::set('mail.mailers.smtp.encryption', getArrayValue($mailConfiguration, 'encryption', 'tls'));
        Config::set('mail.mailers.smtp.username', getArrayValue($mailConfiguration, 'username'));
        Config::set('mail.mailers.smtp.password', getArrayValue($mailConfiguration, 'password'));

        Config::set('mail.from.name', getArrayValue($mailConfiguration, 'from_name', 'hello'));
        Config::set('mail.from.address', getArrayValue($mailConfiguration, 'from_email', 'hello@example.com'));
    }
}
