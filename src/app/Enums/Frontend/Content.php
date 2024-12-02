<?php

namespace App\Enums\Frontend;

use App\Enums\EnumTrait;

enum Content: string
{

    use EnumTrait;

    case FIXED = 'fixed';
    case ENHANCEMENT= 'enhancement';

}
