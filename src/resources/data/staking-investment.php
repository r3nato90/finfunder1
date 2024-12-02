<?php


use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::STAKING_INVESTMENT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::STAKING_INVESTMENT->value, Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Maximizing Profits with Staking Investments",
            "sub_heading" => "Unleashing Passive Income Potential: Harnessing the Power of Staking Investments",
        ])
    ],
];
