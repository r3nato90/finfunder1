<?php

namespace App\Enums;

enum InvestmentType: int
{

    use EnumTrait;

    case INVESTMENT = 1;
    case STAKING_INVESTMENT = 2;
    case MATRIX = 3;
    case TRADE_PREDICTION = 4;

}
