<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::PRICING_PLAN->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::PRICING_PLAN->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Investment Strategies",
            "sub_heading" => "Flexible Options for Every Trading Ambition. Plan aims to cater to different user needs, from those just starting in crypto trading to seasoned investors, providing clear options and benefits for each pricing tier.",
        ])
    ],
];
