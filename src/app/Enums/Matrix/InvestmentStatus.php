<?php
namespace App\Enums\Matrix;

use App\Enums\EnumTrait;

enum InvestmentStatus: int
{
    use EnumTrait;

    case RUNNING = 1;
    case CLOSED = 2;

    public static function getColor(int $status): string
    {
        return match ($status) {
            self::RUNNING->value => 'badge--primary',
            self::CLOSED->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string
    {
        return match ($status) {
            self::RUNNING->value => 'Running',
            self::CLOSED->value => 'Closed',
            default => 'Default'
        };
    }
}


