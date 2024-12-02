<?php

namespace App\Enums\Trade;

use App\Enums\EnumTrait;

enum TradeOutcome: int
{

    use EnumTrait;

    case INITIATED = 1;
    case WIN = 2;
    case LOSE = 3;
    case DRAW = 4;


    public static function getName(int $status): string {
        return match($status) {
            self::INITIATED->value => 'Initiated',
            self::WIN->value => 'Win',
            self::LOSE->value => 'Lose',
            self::DRAW->value => 'Draw',
        };
    }

    public static function getColor(int $status): string {
        return match($status) {
            self::INITIATED->value => 'badge--primary',
            self::WIN->value => 'badge--success',
            self::LOSE->value => 'badge--danger',
            self::DRAW->value => 'badge--info',
            default => 'black'
        };
    }
}
