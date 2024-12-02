<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::INVESTMENT_PROFIT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::INVESTMENT_PROFIT->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Investment Returns Calculator",
            "sub_heading" => "You should understand the calculations before investing in any plan to avoid mistakes. Verify the figures, and you'll find they align with what our calculator indicates.",
        ])
    ],
];
