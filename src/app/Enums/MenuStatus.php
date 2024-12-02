<?php

namespace App\Enums;

enum MenuStatus: int
{
    use EnumTrait;

    case DISABLE= 0;
    case ENABLE = 1;

}
