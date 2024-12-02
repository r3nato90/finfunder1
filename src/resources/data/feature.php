<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::FEATURE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FEATURE->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Real-Time Market Analytics",
            "sub_heading" => "Stay ahead of market trends with FinFunder's real-time analytics. Gain insights into market movements, track asset performance, and make informed decisions with up-to-the-minute data.",
            "btn_name" => "Learn More",
            "btn_url" => "#",
        ]),
    ],
    [
        "name" => SectionName::FEATURE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FEATURE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => '<i class="bi bi-alarm"></i>',
            "title" => 'Secure Investment Environment',
            "details" => 'Security at its finest. Our platform employs advanced encryption and security protocols to ensure your investments are protected at all times. Trade and invest with peace of mind, knowing your assets are in safe hands.',
        ])
    ],
    [
        "name" => SectionName::FEATURE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FEATURE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => '<i class="bi bi-alarm"></i>',
            "title" => 'User-Friendly Interface',
            "details" => 'Navigate the complex world of crypto with ease. FinFunder’s intuitive interface simplifies trading and investing, making it accessible for both beginners and experienced traders.',
        ])
    ],
    [
        "name" => SectionName::FEATURE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FEATURE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => '<i class="bi bi-alarm"></i>',
            "title" => 'Diverse Portfolio Management',
            "details" => 'Expand your investment horizons with our diverse portfolio options. From mainstream cryptocurrencies to emerging tokens, tailor your investment strategy to suit your financial goals.',
        ])
    ], [
        "name" => SectionName::FEATURE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FEATURE->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "icon" => '<i class="bi bi-alarm"></i>',
            "title" => 'Community and Support',
            "details" => 'Join our vibrant community of crypto enthusiasts. Access a wealth of shared knowledge, participate in discussions, and receive dedicated support from our expert team.',
        ])
    ],
];
