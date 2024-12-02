<?php

namespace App\Enums\SMS;

use App\Enums\EnumTrait;

enum SmsGatewayName: string
{
    use EnumTrait;

    case TWILIO = 'TWILIO102';
    case BIRD = 'IMESSAGE103';
    case MAGIC = 'MAGIC104';

}
