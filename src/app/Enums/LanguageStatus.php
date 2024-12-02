<?php

namespace App\Enums;

enum LanguageStatus: int
{
    use EnumTrait;

    case DISABLE= 0;
    case ENABLE = 1;
    case DEFAULT = 2;
}
