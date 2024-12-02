<?php

namespace App\Enums\Investment\Staking;

use App\Enums\EnumTrait;

enum Status: int
{
    use EnumTrait;

    case RUNNING = 1;
    case COMPLETED = 2;


    public static function getColor(int $status): string {
        return match($status) {
            self::RUNNING->value => 'badge--success',
            self::COMPLETED->value => 'badge--info',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::RUNNING->value => 'Running',
            self::COMPLETED->value => 'Completed',
            default => 'Default'
        };
    }
}
