<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::PAGE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::PAGE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "name" => "Privacy Policy",
            "descriptions" => "The original and most valuable cryptocurrency, Bitcoin is often seen as a digital.",
        ])
    ],
    [
        "name" => SectionName::PAGE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::PAGE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "name" => "Terms & Conditions",
            "descriptions" => "The original and most valuable cryptocurrency, Bitcoin is often seen as a digital.",
        ])
    ],
];
