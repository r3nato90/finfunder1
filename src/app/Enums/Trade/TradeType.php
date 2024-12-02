<?php

namespace App\Enums\Trade;

use App\Enums\EnumTrait;

enum TradeType: int
{
    use EnumTrait;

    case PRACTICE = 0;
    case TRADE = 1;


    public static function getColor(int $status): string {
        return match($status) {
            self::PRACTICE->value => 'badge--primary',
            self::TRADE->value => 'badge--primary',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match ($status) {
            self::PRACTICE->value => 'PRACTICE',
            self::TRADE->value => 'TRADE',
            default => 'Default'
        };
    }
}
