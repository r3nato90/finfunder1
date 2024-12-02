<?php
namespace App\Enums\Theme;

use App\Enums\EnumTrait;

enum FileType: string
{
    use EnumTrait;
    case CSS = 'css';
    case JS = 'js';

}

