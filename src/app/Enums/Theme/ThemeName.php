<?php

namespace App\Enums\Theme;

use App\Enums\EnumTrait;

enum ThemeName: string
{
    use EnumTrait;
    case DEFAULT_THEME = 'default_theme';
    case BLUE_THEME = 'blue_theme';
}


