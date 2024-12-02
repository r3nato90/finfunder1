<?php

namespace App\Enums;

enum CommissionType: int
{
    use EnumTrait;

    case INVESTMENT = 1;
    case REFERRAL = 2;
    case LEVEL = 3;
    case DEPOSIT = 4;

}
