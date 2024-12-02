<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::SIGN_IN->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SIGN_IN->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Access Your Trading Hub",
            'title' => "Step Into the World of Smart Trading",
            'details' => "Enter the realm of FinFunder, where cutting-edge blockchain technology meets seamless trading experiences. As the industry evolves amidst global regulatory developments, stay ahead with our secure, intuitive platform. Ready to make your mark in the dynamic world of cryptocurrency?",
            "background_image" => "form-bg3.jpg",
        ])
    ],
];
