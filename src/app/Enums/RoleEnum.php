<?php

namespace App\Enums;

enum RoleEnum: int
{
    use EnumTrait;
    case OWNER = 1;
    case TRANSLATOR = 2;

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Owner',
            self::TRANSLATOR => 'Translator',
        };
    }
    public function description(): string
    {
        return match ($this) {
            self::OWNER => 'Full access to everything',
            self::TRANSLATOR => 'Can translate phrases for a language or multiple languages',
        };
    }
}

