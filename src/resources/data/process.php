<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

$processKey = FrontendService::callBasedOnValues(SectionKey::PROCESS->value,Content::ENHANCEMENT->value);

return [
    [
        "name" => SectionName::PROCESS->value,
        "key" => $processKey,
        "meta" => json_encode([
            "icon" => "<i class='bi bi-box-arrow-in-right'></i>",
            "title" => "Matrix",
            "details" => "Harness the power of community-driven growth in the cryptocurrency space with Matrix. Expand your network, refer, and earn, all while contributing to a collective success story."
        ])
    ],
    [
        "name" => SectionName::PROCESS->value,
        "key" => $processKey,
        "meta" => json_encode([
            "icon" => "<i class='bi bi-currency-dollar'></i>",
            "title" => "Invest",
            "details" => "Experience secure, stress-free investing where risk is mitigated, and profit maximization is a reality. Our platform is designed for seamless, intelligent investment strategies in crypto"
        ])
    ],
    [
        "name" => SectionName::PROCESS->value,
        "key" => $processKey,
        "meta" => json_encode([
            "icon" => "<i class='bi bi-bar-chart'></i>",
            "title" => "Trade",
            "details" => "Elevate your trading skills in cryptocurrency pairs with smart, intuitive tools. Our platform caters to experts seeking sophisticated, yet accessible, trading environments for enhanced profitability."
        ])
    ],
];
