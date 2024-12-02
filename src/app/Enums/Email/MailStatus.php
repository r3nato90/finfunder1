<?php

namespace App\Enums\Email;
use App\Enums\EnumTrait;

enum MailStatus: int
{
    use EnumTrait;

    case INACTIVE = 0;
    case ACTIVE = 1;
}
