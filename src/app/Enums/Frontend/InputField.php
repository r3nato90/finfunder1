<?php

namespace App\Enums\Frontend;

use App\Enums\EnumTrait;

enum InputField: string
{
    use EnumTrait;

    case TEXT = "text";
    case FILE = "file";
    case TEXTAREA = "textarea";
    case TEXTAREA_EDITOR = "textarea-editor";
    case SELECT = "select";
    case CHECKBOX = "checkbox";
    case RADIO = "radio";
    case ICON = 'icon';

}
