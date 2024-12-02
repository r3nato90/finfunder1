<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::TESTIMONIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::TESTIMONIAL->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Success Stories from Our Clients",
            "sub_heading" => "Discover how FinFunder has empowered individuals and businesses in their crypto trading and investment journey. ",
            "title" => "Amazing !",
            "total_reviews" => "885 Reviews",
            "avg_rating" => "4"
        ])
    ],
    [
        "name" => SectionName::TESTIMONIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::TESTIMONIAL->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "testimonial" => "As a professional in finance, I'm impressed by FinFunder's precise market analytics and user-friendly interface. It's revolutionized the way I approach crypto investment. Highly recommended for those who value data-driven decisions.",
            "name" => "Alex Johnson",
            "designation" => "Financial Analyst"
        ])
    ],
    [
        "name" => SectionName::TESTIMONIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::TESTIMONIAL->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "testimonial" => " FinFunder's commitment to security and innovative technology stands out in the crypto world. It's the only platform I trust for managing my diverse crypto portfolio. The interface is incredibly intuitive, even for beginners.",
            "name" => "Emily Torres",
            "designation" => "Tech Entrepreneur"
        ])
    ],
    [
        "name" => SectionName::TESTIMONIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::TESTIMONIAL->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "testimonial" => "What I love about FinFunder is the community aspect. It's not just a trading platform; it's a hub of knowledge and insights. The support team is fantastic, always ready to help with any queries.",
            "name" => "David Kim",
            "designation" => "Crypto Enthusiast"
        ])
    ],
    [
        "name" => SectionName::TESTIMONIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::TESTIMONIAL->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "testimonial" => "I've used several trading platforms, but FinFunder stands out for its ease of use and comprehensive features. It's my go-to for all my crypto investments. The real-time data has been crucial for my investment strategies.",
            "name" => "Sarah Bennett",
            "designation" => "Investor"
        ])
    ],
    [
        "name" => SectionName::TESTIMONIAL->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::TESTIMONIAL->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "testimonial" => "From a developer's perspective, I appreciate FinFunder's robust security measures and cutting-edge tech. It's great to see a platform that not only prioritizes user experience but also the safety and integrity of digital assets.",
            "name" => "Michael Smith",
            "designation" => "Blockchain Developer"
        ])
    ],
];
