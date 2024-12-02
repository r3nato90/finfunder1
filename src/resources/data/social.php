<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::SOCIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SOCIAL->value,Content::FIXED->value),
        "meta" => json_encode([
            "facebook_icon" => "<i class='bi bi-facebook'></i>",
            "facebook_url" => "https://www.facebook.com/",
            "twitter_icon" => "<i class='bi bi-twitter'></i>",
            "twitter_url" => "https://www.twitter.com/",
            "instagram_icon" => "<i class='bi bi-instagram'></i>",
            "instagram_url" => "https://www.instagram.com/",
            "tiktok_icon" => "<i class='bi bi-tiktok'></i>",
            "tiktok_url" => "https://www.tiktok.com/",
            "telegram_icon" => "<i class='bi bi-telegram'></i>",
            "telegram_url" => "https://www.telegram.com/",
        ])
    ],
];
