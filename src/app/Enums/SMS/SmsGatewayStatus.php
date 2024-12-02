<?php

namespace App\Enums\SMS;

use App\Enums\EnumTrait;

enum SmsGatewayStatus: int
{
    use EnumTrait;

    case INACTIVE = 0;
    case ACTIVE = 1;
}
