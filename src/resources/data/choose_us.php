<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::CHOOSE_US->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CHOOSE_US->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Advanced Predictive Analytics",
            "sub_heading" => "Utilize our sophisticated prediction methods to stay ahead in the market. Our technology analyzes trends to enhance your trading strategy and maximize returns.",
            "vector_image" => "bit-tech.png"
        ])
    ],
    [
        "name" => SectionName::CHOOSE_US->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CHOOSE_US->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Elliott Wave Analysis",
            "details" => "Leverage Elliott Wave Analysis for deeper market insights. This powerful tool helps in identifying market cycles and trends, offering you a strategic edge in trading.",
            "icon" => "<i class='bi bi-graph-up-arrow'></i>"
        ])
    ],
    [
        "name" => SectionName::CHOOSE_US->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CHOOSE_US->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "MACD and RSI Indicators",
            "details" => "Make informed decisions using MACD and RSI indicators. These tools provide valuable insights into market momentum and trends, enhancing your analysis and decision-making.",
            "icon" => "<i class='bi bi-app-indicator'></i>"
        ])
    ],
    [
        "name" => SectionName::CHOOSE_US->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CHOOSE_US->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Turbo Speed Execution",
            "details" => "Experience unparalleled speed with our Turbo Speed feature. Swift execution of trades means you never miss an opportunity in the fast-paced crypto market.",
            "icon" => "<i class='bi bi-fan'></i>"
        ])
    ],
    [
        "name" => SectionName::CHOOSE_US->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CHOOSE_US->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "High Low Option Trading",
            "details" => "Explore High Low Option Trading for a straightforward approach to the market. This feature simplifies decision-making and is suitable for both beginners and seasoned traders.",
            "icon" => "<i class='bi bi-graph-up'></i>"
        ])
    ],
];
