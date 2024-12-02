<?php

namespace App\Enums;

enum RegistrationStatus: int
{
    use EnumTrait;

    case ENABLE = 1;
    case DISABLE= 0;
}
