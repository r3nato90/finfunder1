<?php

namespace App\Enums\Payment;

use App\Enums\EnumTrait;

enum NotificationType: int
{
    use EnumTrait;

    case APPROVED = 1;
    case REJECTED = 2;
    case REQUESTED = 3;
    case COMPLETE = 4;
    case RE_INVEST = 5;
    case CANCEL = 6;
}
