<?php

namespace App\Enums\Payment;

use App\Enums\EnumTrait;

enum GatewayType: int
{

    use EnumTrait;

    case AUTOMATIC = 1;
    case MANUAL = 2;
}
