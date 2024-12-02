<?php

namespace App\Enums\Transaction;

use App\Enums\EnumTrait;

enum Type: int
{
    use EnumTrait;
    case PLUS = 1;
    case MINUS = 2;

    public static function getName(int $status): string {
        return match ($status) {
            self::PLUS->value => 'Add Balance',
            self::MINUS->value =>  'Subtract Balance',
            default => 'Default'
        };
    }


    public static function getTextColor(int $status): string {
        return match ($status) {
            self::PLUS->value => 'success',
            self::MINUS->value => 'danger',
            default => 'Default'
        };
    }
}
