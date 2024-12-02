<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::SIGN_UP->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::SIGN_UP->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Create Your FinFunder Account",
            'title' => "Join Today & Receive up to 100 USDT Bonus",
            'details' => "Embark on a journey with FinFunder, where innovation meets opportunity in the dynamic world of blockchain and cryptocurrency. As the market evolves with heightened interest and regulatory developments, position yourself for success with our advanced, secure platform. Begin your trading adventure with a welcome bonus!",
            "background_image" => "form-bg3.jpg",
        ])
    ],
];
