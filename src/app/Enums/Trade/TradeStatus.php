<?php

namespace App\Enums\Trade;

use App\Enums\EnumTrait;

enum TradeStatus: int
{
    use EnumTrait;

    case RUNNING = 1;
    case COMPLETE = 2;

    public static function getColor(int $status): string {
        return match($status) {
            self::RUNNING->value => 'badge--primary',
            self::COMPLETE->value => 'badge--success',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match ($status) {
            self::RUNNING->value => 'Running',
            self::COMPLETE->value => 'Complete',
            default => 'Default'
        };
    }

}
