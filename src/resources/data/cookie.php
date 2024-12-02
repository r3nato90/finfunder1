<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::COOKIE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::COOKIE->value,Content::FIXED->value),
        "meta" => json_encode([
            "title" => "We use cookies to enhance your browsing experience. By clicking 'Accept all, you agree to the use of cookies.",
        ]),
    ],
];
