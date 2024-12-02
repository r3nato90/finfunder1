<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Innovators in the Digital Finance Realm",
            "sub_heading" => "Pioneering Your Crypto Journey with Expertise. Our team, a blend of tech wizards and financial aficionados, harnesses the power of Laravel to bring you a seamless, secure, and sophisticated trading platform. Here's what sets us apart:",
            "first_item_title" => "Trading Pair",
            "first_item_count" => "167",
            "second_item_title" => "Happy Client",
            "second_item_count" => "312",
            "third_item_title" => "Investor",
            "third_item_count" => "154",
            "first_image" => 'about-1.jpg',
            "second_image" => 'about-vector.png',
            "vector_image" => 'about-2.jpg',
        ]),
    ],
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => "<i class='bi bi-check2-circle'></i>",
            "title" => "Deep market analysis and insights, empowering informed trading decisions.",
        ])
    ],
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => "<i class='bi bi-check2-circle'></i>",
            "title" => "Leveraging Laravel's advanced features for a robust, secure platform.",
        ])
    ],
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => "<i class='bi bi-check2-circle'></i>",
            "title" => "Intuitive interfaces that cater to both novices and professional traders.",
        ])
    ],
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => "<i class='bi bi-check2-circle'></i>",
            "title" => "Round-the-clock assistance and educational resources for continuous learning.",
        ])
    ],
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => "<i class='bi bi-check2-circle'></i>",
            "title" => "Worldwide service with a keen understanding of local market nuances.",
        ])
    ],
    [
        "name" => SectionName::ABOUT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::ABOUT->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => "<i class='bi bi-check2-circle'></i>",
            "title" => "FinFunder emerges at the forefront of digital finance innovation, dedicated to revolutionizing your experience in the cryptocurrency domain.",
        ])
    ],
];
