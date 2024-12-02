<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::BANNER->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BANNER->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Refine Invest and Trade Tactics with Matrix",
            "sub_heading" => "Begin your financial evolution with FinFunder's groundbreaking Matrix model, a gateway to enhanced earnings and expansive customer reach. Progress to intelligent investment opportunities, tailored for savvy growth.",
            "first_text" => "90.00M+",
            "second_text" => "Users from the WorldWide",
            "first_icon" => '<i class="bi bi-bar-chart"></i>',
            "first_title" => "Fast Trading",
            "second_icon" => '<i class="bi bi-shield-check"></i>',
            "second_title" => "Secure & Reliable",
            "third_icon" => '<i class="bi bi-arrow-repeat"></i>',
            "third_title" => "Continuous Market Updates",
            "btn_name" => "Get Started",
            "btn_url" => route('home'),
            "video_link" => "https://youtu.be/hT_nvWreIhg",
            "main_image" => "Group.png",
            "background_image" => "banner-bg.png",
            "first_provider_image" => "banner-coin1.png",
            "second_provider_image" => "banner-coin2.png",
            "third_provider_image" => "banner-coin3.png",
            "fourth_provider_image" => "banner-coin4.png",
        ])
    ],
];
