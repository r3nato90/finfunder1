<?php

namespace App\Enums\Theme;

use App\Enums\EnumTrait;

enum ThemeType: string
{
    use EnumTrait;

    case ADMIN = 'admin';
    case FRONTEND = 'frontend';
    case USER = 'user';
    case GLOBAL = 'global';
    case INSTALLER = 'installler';
    case AUTH = 'auth';

}
