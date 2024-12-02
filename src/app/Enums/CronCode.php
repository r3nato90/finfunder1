<?php

namespace App\Enums;

enum CronCode: int
{
    use EnumTrait;

    case CRYPTO_CURRENCY = 1;
    case INVESTMENT_PROCESS = 2;
    case TRADE_OUTCOME = 3;
    case QUEUE_WORK = 4;
}
