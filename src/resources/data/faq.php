<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Frequently Asked Questions",
            "sub_heading" => "Your Queries Answered: Unveiling the Essentials of Crypto Trading and Investment with FinFunder",
            "btn_name" => "More Questions ?",
            "btn_url" => route('home'),
            "bg_image" => "faq-image.png",
        ])
    ],
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "question" => "What is FinFunder?",
            "answer" => "FinFunder is a cutting-edge crypto trading and investment platform, offering a range of services from real-time trading to strategic investment planning, all powered by Laravel technology.",
        ])
    ],
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "question" => "How do I start trading on FinFunder?",
            "answer" => "Getting started is simple. Just create an account, complete the verification process, and you'll be ready to fund your account and begin trading.",
        ])
    ],
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "question" => "Is my investment safe with FinFunder?",
            "answer" => "Yes, we prioritize the security of our users' investments. Our platform employs advanced security protocols and encryption to safeguard your assets and personal information.",
        ])
    ],
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "question" => "Can beginners use FinFunder effectively?",
            "answer" => "Absolutely! Our platform is designed for users of all skill levels. We offer educational resources and intuitive tools to help beginners navigate the crypto market confidently.",
        ])
    ],
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "question" => "What makes FinFunder different from other crypto platforms?",
            "answer" => "FinFunder stands out with its user-friendly interface, comprehensive market analytics, community-driven insights, and our commitment to using Laravel's robust framework for optimal performance and security.",
        ])
    ],
    [
        "name" => SectionName::FAQ->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::FAQ->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "question" => "What is the Matrix Plan, and how does it benefit me?",
            "answer" => "The Matrix Plan is a unique community-focused program that connects you with other crypto enthusiasts for shared insights and strategies, enhancing your trading experience through collective wisdom.",
        ])
    ],
];
