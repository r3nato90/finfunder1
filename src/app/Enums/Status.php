<?php

namespace App\Enums;

enum Status: int
{
    use EnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 2;

    public static function getColor(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'badge--success',
            self::INACTIVE->value => 'badge--danger',
            default => 'black'
        };
    }

    public static function getName(int $status, bool $is_bool = false): string {
        return match ($status) {
            self::ACTIVE->value => $is_bool ? 'Yes' : 'Active',
            self::INACTIVE->value => $is_bool ? 'No' : 'Inactive',
            default => 'Default'
        };
    }


}
