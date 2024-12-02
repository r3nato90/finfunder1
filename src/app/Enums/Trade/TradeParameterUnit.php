<?php

namespace App\Enums\Trade;

use App\Enums\EnumTrait;

enum TradeParameterUnit: string
{
    use EnumTrait;
    case MINUTES = "Minutes";
    case HOURS = "Hours";

    public static function getColor(string $status): string {
        return match($status) {
            self::MINUTES->value => 'badge--primary',
            self::HOURS->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(string $status): string {
        return match($status) {
            self::MINUTES->value => 'Minutes',
            self::HOURS->value => 'Hours',
            default => 'Default'
        };
    }

}
