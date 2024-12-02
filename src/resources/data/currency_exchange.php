<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::CURRENCY_EXCHANGE->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CURRENCY_EXCHANGE->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Advanced Currency Exchange",
            "sub_heading" => "Navigate the cryptocurrency market with precision. Our platform offers real-time pricing, comprehensive market analysis, and trend forecasts to inform and enhance your trading strategy. Stay ahead in the dynamic world of crypto with FinFunder's insightful exchange tools."
        ])
    ],
];
