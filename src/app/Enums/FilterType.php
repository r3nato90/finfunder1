<?php

namespace App\Enums;

enum FilterType: int
{
    case SELECT_OPTIONS = 1;
    case TEXT = 2;
    case DATE_RANGE = 3;
}
