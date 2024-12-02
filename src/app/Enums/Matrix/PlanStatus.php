<?php

namespace App\Enums\Matrix;

use App\Enums\EnumTrait;

enum PlanStatus: int
{
    use EnumTrait;

    case ENABLE = 1;
    case DISABLE = 2;

    public static function getColor(int $status): string {
        return match($status) {
            self::ENABLE->value => 'badge--primary',
            self::DISABLE->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::ENABLE->value => 'Enable',
            self::DISABLE->value => 'Disable',
            default => 'Default'
        };
    }
}


