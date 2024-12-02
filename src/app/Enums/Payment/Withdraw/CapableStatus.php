<?php

namespace App\Enums\Payment\Withdraw;

use App\Enums\EnumTrait;

enum CapableStatus: int
{
    use EnumTrait;

    case NO = 0;
    case YES = 1;

    public static function getColor(int $status): string {
        return match($status) {
            self::YES->value => 'badge--primary',
            self::NO->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::YES->value => 'Yes',
            self::NO->value => 'No',
            default => 'Default'
        };
    }

}
