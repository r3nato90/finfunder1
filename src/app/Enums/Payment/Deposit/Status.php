<?php

namespace App\Enums\Payment\Deposit;

use App\Enums\EnumTrait;

enum Status: int
{
    use EnumTrait;

    case INITIATED = 1;
    case PENDING = 2;
    case SUCCESS = 3;
    case CANCEL = 4;

    public static function getColor(int $status): string {

        return match($status) {
            self::INITIATED->value => 'badge--primary',
            self::PENDING->value => 'badge--info',
            self::SUCCESS->value => 'badge--success',
            self::CANCEL->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {

        return match($status) {
            self::INITIATED->value => 'Initiated',
            self::PENDING->value => 'Pending',
            self::SUCCESS->value => 'Success',
            self::CANCEL->value => 'Cancel',
            default => 'Default'
        };

    }
}
