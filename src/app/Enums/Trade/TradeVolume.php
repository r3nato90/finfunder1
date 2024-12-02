<?php

namespace App\Enums\Trade;

use App\Enums\EnumTrait;

enum TradeVolume: int
{
    use EnumTrait;

    case HIGH = 1;
    case LOW = 2;


    public static function getName(int $status): string {
        return match($status) {
            self::HIGH->value => 'High',
            self::LOW->value => 'Low',
        };
    }

    public static function getColor(int $status): string {
        return match($status) {
            self::HIGH->value => 'badge--success',
            self::LOW->value => 'badge--danger',
            default => 'black'
        };
    }


}
