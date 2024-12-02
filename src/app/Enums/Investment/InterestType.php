<?php

namespace App\Enums\Investment;

use App\Enums\EnumTrait;

enum InterestType: int
{
    use EnumTrait;
    case PERCENT = 1;
    case FIXED = 2;


    public static function getColor(int $status): string {
        return match($status) {
            self::PERCENT->value => 'badge--success',
            self::FIXED->value => 'badge--info',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::PERCENT->value => 'Percent',
            self::FIXED->value => 'Fixed',
            default => 'Default'
        };
    }

    public static function getSymbol(int $status): string {
        return match($status) {
            self::PERCENT->value => '%',
            self::FIXED->value => ' '.getCurrencyName(),
            default => 'Default'
        };
    }
}
