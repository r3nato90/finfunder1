<?php

namespace App\Enums\Payment\Withdraw;

use App\Enums\EnumTrait;

enum MethodStatus: int
{
    use EnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 0;

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
