<?php

namespace App\Enums\Payment;

use App\Enums\EnumTrait;

enum GatewayStatus: int
{
    use EnumTrait;

    case INACTIVE = 0;
    case ACTIVE = 1;


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
            self::INACTIVE->value => 'Success',
            default => 'Default'
        };
    }
}
