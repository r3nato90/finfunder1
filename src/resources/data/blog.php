<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;
use App\Services\FrontendService;

return [
    [
        "name" => SectionName::BLOG->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BLOG->value,Content::FIXED->value),
        "meta" => json_encode([
            "heading" => "Explore Insights with Our Blog",
            "sub_heading" => "Dive into the world of cryptocurrency and blockchain technology. Our blog brings you the latest trends, expert analyses, and insightful articles to enhance your understanding and trading skills. Stay informed, stay ahead."
        ])
    ],
    [
        "name" => SectionName::BLOG->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BLOG->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Bitcoin: The Digital Gold Standard",
            "description" => "Explore how Bitcoin has revolutionized the digital currency landscape, its journey from inception to becoming the most valuable cryptocurrency, and what this means for future digital currencies.",
            "thumb_image" => "blog1.jpg",
            "main_image" => "blog1.jpg",
        ])
    ],
    [
        "name" => SectionName::BLOG->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BLOG->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Decoding Bitcoin: More Than Just a Cryptocurrency",
            "description" => "A comprehensive guide to understanding Bitcoin beyond its monetary value - its technological infrastructure, blockchain, and how it's more than just a currency.",
            "thumb_image" => "blog2.jpg",
            "main_image" => "blog2.jpg",
        ])
    ],
    [
        "name" => SectionName::BLOG->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BLOG->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Bitcoin's Influence on Global Finance",
            "description" => "Delve into Bitcoin's impact on the global financial system, its role in shaping digital transactions, and how it's being integrated into mainstream finance.",
            "thumb_image" => "blog3.jpg",
            "main_image" => "blog3.jpg",
        ])
    ],
    [
        "name" => SectionName::BLOG->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BLOG->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "Investing in Bitcoin: Risks and Rewards",
            "description" => "An investor’s perspective on Bitcoin - examining the potential risks and lucrative rewards of investing in the world's first and most popular cryptocurrency.",
            "thumb_image" => "blog4.jpg",
            "main_image" => "blog4.jpg",
        ])
    ],
    [
        "name" => SectionName::BLOG->value,
        "key" => FrontendService::callBasedOnValues(SectionKey::BLOG->value,Content::ENHANCEMENT->value),
        "meta" => json_encode([
            "title" => "The Future of Bitcoin: Predictions and Possibilities",
            "description" => "Speculating the future of Bitcoin - trends, predictions, and the evolving landscape of cryptocurrency. What does the future hold for this digital pioneer?",
            "thumb_image" => "blog5.jpg",
            "main_image" => "blog5.jpg",
        ])
    ],
];
