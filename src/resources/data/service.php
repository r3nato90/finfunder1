<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::SERVICE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SERVICE->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Expertise in Crypto Excellence",
            "sub_heading" => "Harness the full potential of cryptocurrency with our comprehensive suite of trading and investment services, tailored to meet the needs of both novice and seasoned investors.",
        ])
    ],
    [
        "name" => SectionName::SERVICE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SERVICE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "01. Best Payout",
            "service_image" => "service-1.jpg",
        ])
    ],
    [
        "name" => SectionName::SERVICE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SERVICE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "02. Fund Access",
            "service_image" => "service-2.jpg",
        ])
    ],
    [
        "name" => SectionName::SERVICE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SERVICE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "03. Amazing Support",
            "service_image" => "service-3.jpg",
        ])
    ],
    [
        "name" => SectionName::SERVICE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SERVICE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "04. Cashback Option",
            "service_image" => "service-4.jpg",
        ])
    ],
];
