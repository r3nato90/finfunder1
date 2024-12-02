<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::CRYPTO_PAIRS->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CRYPTO_PAIRS->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Top Crypto Conversions at Your Fingertips",
            "sub_heading" => "Explore the most popular cryptocurrency conversions on FinFunder. Our platform provides you with the latest, most sought-after exchange rates, ensuring you're always informed about high-performing currencies. Efficient, accurate, and designed for savvy traders like you.",
            "conversion_image" => 'usdt.png',
        ])
    ],
];
