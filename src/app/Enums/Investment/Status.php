<?php

namespace App\Enums\Investment;

use App\Enums\EnumTrait;

enum Status: int
{
    use EnumTrait;

    case INITIATED = 1;
    case PROFIT_COMPLETED = 2;
    case COMPLETED = 3;
    case CANCELLED = 4;

    public static function getColor(int $status): string {
        return match($status) {
            self::INITIATED->value => 'badge--primary',
            self::PROFIT_COMPLETED->value => 'badge--info',
            self::COMPLETED->value => 'badge--success',
            self::CANCELLED->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::INITIATED->value => 'Initiated',
            self::PROFIT_COMPLETED->value => 'Profit Completed',
            self::COMPLETED->value => 'Completed',
            self::CANCELLED->value => 'Cancelled',
            default => 'Default'
        };
    }


}
