<?php

namespace App\Enums\Investment;

use App\Enums\EnumTrait;

enum Recapture: int
{
    use EnumTrait;

    case YES = 1;
    case NO = 2;
    case HOLD = 3;

    public static function getName(int $status): string {
        return match($status) {
            self::YES->value => 'Yes',
            self::NO->value => 'No',
            self::HOLD->value => 'Hold',
            default => 'Default'
        };
    }


    public static function getColor(int $status): string {
        return match($status) {
            self::YES->value => 'badge--success',
            self::NO->value => 'badge--danger',
            self::HOLD->value => 'badge--primary',
            default => 'black'
        };
    }
}
