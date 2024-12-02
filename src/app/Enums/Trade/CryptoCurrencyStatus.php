<?php

namespace App\Enums\Trade;

use App\Enums\EnumTrait;

enum CryptoCurrencyStatus: int
{

    use EnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 2;


    public static function getColor(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'badge--primary',
            self::INACTIVE->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'Active',
            self::INACTIVE->value => 'Inactive',
            default => 'Default'
        };
    }
}
