<?php

namespace App\Enums\User;

use App\Enums\EnumTrait;

enum KycStatus: int
{
    use EnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 2;
    case REQUESTED = 3;

    public static function getColor(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'badge--success',
            self::REQUESTED->value => 'badge--primary',
            self::INACTIVE->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'Active',
            self::REQUESTED->value => 'Requested',
            self::INACTIVE->value => 'Inactive',
            default => 'Default'
        };
    }
}
