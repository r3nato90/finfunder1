<?php

namespace App\Enums\Transaction;

use App\Enums\EnumTrait;

enum BalanceType: int
{
    use EnumTrait;

    case INVESTMENT = 1;
    case TRADE = 2;


}
