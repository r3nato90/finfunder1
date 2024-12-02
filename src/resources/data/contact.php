<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::CONTACT->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::CONTACT->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Prompt Support, Just an Hour Away",
            "sub_heading" => "Need assistance or have a query? Reach out to us! We're committed to providing you with timely and helpful responses. For immediate assistance, our customer service team is readily available via phone or email. We value your time and strive to address your needs swiftly and efficiently.",
            "title" => "Connect With Us",
            "email" => "info@example.com",
            "phone" => "+9943453453",
            "address" => "123 Main Street, Suite 456 Cityville, State 78901",
            "background_image" => 'contact-image',
        ])
    ],
];
