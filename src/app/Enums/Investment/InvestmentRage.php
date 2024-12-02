<?php

namespace App\Enums\Investment;

use App\Enums\EnumTrait;

enum InvestmentRage: int
{
    use EnumTrait;

    case RANGE = 1;
    case FIXED = 2;


    public static function getColor(int $status): string {
        return match($status) {
            self::RANGE->value => 'badge--success',
            self::FIXED->value => 'badge--info',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::RANGE->value => 'Range',
            self::FIXED->value => 'Fixed',
            default => 'Default'
        };
    }
}
