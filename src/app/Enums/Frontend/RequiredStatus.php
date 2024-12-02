<?php

namespace App\Enums\Frontend;

use App\Enums\EnumTrait;

enum RequiredStatus: int
{
    use EnumTrait;

    case YES = 1;
    case NO = 2;


}
