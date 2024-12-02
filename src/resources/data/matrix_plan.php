<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::PRICING_PLAN->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::MATRIX_PLAN->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Unlock the Power of Community",
            "sub_heading" => "Embrace the synergy of collective crypto wisdom with our Matrix Elite Plan. This plan connects you to a network of fellow enthusiasts and experts, enabling knowledge sharing, collaborative strategies, and exclusive community insights. ",
            "award_image" => "award.png"
        ])
    ],
];


