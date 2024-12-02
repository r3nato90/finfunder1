<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::CRYPTO_COIN->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CRYPTO_COIN->value,Content::FIXED->value),
        "meta" => json_encode([
            "first_crypto_coin" => "eth.png",
            "second_crypto_coin" => "bnb.png",
            "third_crypto_coin" => "ada.png",
            "fourth_crypto_coin" => "sol.png",
        ])
    ],
];
