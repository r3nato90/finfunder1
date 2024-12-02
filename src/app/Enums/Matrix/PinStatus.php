<?php

namespace App\Enums\Matrix;

use App\Enums\EnumTrait;

enum PinStatus:int
{
    use EnumTrait;

    case UNUSED = 0;
    case USED = 1;

    public static function getColor(int $status): string {
        return match($status) {
            self::UNUSED->value => 'badge--primary',
            self::USED->value => 'badge--success',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::UNUSED->value => 'Unused',
            self::USED->value => 'Used',
            default => 'Default'
        };
    }
}
