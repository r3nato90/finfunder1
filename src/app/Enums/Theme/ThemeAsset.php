<?php

namespace App\Enums\Theme;

use App\Enums\EnumTrait;

enum ThemeAsset: string
{
    use EnumTrait;
    case ADMIN = 'assets/theme/admin';
    case FRONTEND = 'assets/theme/frontend';
    case AUTH = 'assets/theme/auth';
    case USER = 'assets/theme/user';
    case GLOBAL = 'assets/theme/global';
    case INSTALLER = 'assets/theme/installer';
    case FRONT = 'assets/theme/font';

}
