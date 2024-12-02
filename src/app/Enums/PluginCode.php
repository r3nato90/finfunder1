<?php

namespace App\Enums;

enum PluginCode: string
{
    use EnumTrait;

    case TAWK = 'TAWK-111';

    case GOOGLE_ANALYTICS = 'GOOGLE-ANALYTICS';
    case HOORY = 'hoory-113';

}
