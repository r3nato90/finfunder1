<?php

namespace App\Enums;

enum TicketPriorityStatus: int
{
    use EnumTrait;

    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;

    public static function getColor(int $status): string {
        return match($status) {
            self::LOW->value => 'badge--primary',
            self::MEDIUM->value => 'badge--success',
            self::HIGH->value => 'badge--info',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::LOW->value => 'Low',
            self::MEDIUM->value => 'Medium',
            self::HIGH->value => 'High',
            default => 'Default'
        };
    }
}
