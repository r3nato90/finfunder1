<?php

namespace App\Enums\Investment;

use App\Enums\EnumTrait;

enum ReturnType: int
{
    use EnumTrait;

    case LIFETIME = 1;
    case REPEAT = 2;


    public static function getName(int $status): string {
        return match($status) {
            self::LIFETIME->value => 'LifeTime',
            self::REPEAT->value => 'Repeat',
            default => 'Default'
        };
    }

}
