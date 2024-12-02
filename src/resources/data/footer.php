<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::FOOTER->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FOOTER->value, Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Stay Connected with FinFunder",
            "footer_vector" => "footer-vector.png",
            "news_letter" => "Join the FinFunder Newsletter",
            "news_letter_title" => "Subscribe to our newsletter for the latest crypto trends, FinFunder updates, and exclusive insights.",
            "details" => "FinFunder is your trusted partner in navigating the crypto world. We're here to assist you 24/7 with any queries and provide support for your trading and investment needs. Discover more about us, access our help center, and follow our social channels for the latest updates and insights.",
            "copy_right_text" => "© " . carbon()->format('Y') . "by" . getSiteTitle() . ". All Rights Reserved.",
        ])
    ],
];
