<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::ADVERTISE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ADVERTISE->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Elevate Your Trading Journey with FinFunder",
            "sub_heading" => "Exceptional Trading Conditions Tailored for Your Success",
        ])
    ],
    [
        "name" => SectionName::ADVERTISE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ADVERTISE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Optimized Balance Base Draw down",
            "advertise_image" => "advertise-1.jpg",
        ])
    ],
    [
        "name" => SectionName::ADVERTISE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ADVERTISE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Strategic Balance Base Management",
            "advertise_image" => "advertise-1.jpg",
        ])
    ],
    [
        "name" => SectionName::ADVERTISE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ADVERTISE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "20% Profit Share in Challenge Phase",
            "advertise_image" => "advertise-2.jpg",
        ])
    ],
    [
        "name" => SectionName::ADVERTISE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ADVERTISE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Unlimited Trading Opportunities",
            "advertise_image" => "advertise-3.jpg",
        ])
    ],
    [
        "name" => SectionName::ADVERTISE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ADVERTISE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Exclusive Limited-Time Offers",
            "advertise_image" => "advertise-4.jpg",
        ])
    ],
];
