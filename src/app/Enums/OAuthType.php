<?php

namespace App\Enums;

enum OAuthType: string
{
    use EnumTrait;

    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';


    public static function getColumnName(string $status): string {
        return match ($status) {
            self::GOOGLE->value => 'google_id',
            self::FACEBOOK->value => 'facebook_id',
            default => 'Default'
        };
    }

}
