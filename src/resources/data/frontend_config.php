<?php

use App\Enums\Frontend\Content;
use App\Enums\Frontend\SectionKey;
use App\Enums\Frontend\SectionName;

$data = [
    "sections" => [
        SectionKey::ABOUT->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::ABOUT->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "first_item_title" => "text",
                "first_item_count" => "text",
                "second_item_title" => "text",
                "second_item_count" => "text",
                "third_item_title" => "text",
                "third_item_count" => "text",
                "images" => [
                    "first_image" => [
                        "size" => "650x600"
                    ],
                    "second_image" => [
                        "size" => "650x600"
                    ],
                    "vector_image" => [
                        "size" => "1447x1327"
                    ]
                ]
            ],
            Content::ENHANCEMENT->value => [
                "icon" => "icon",
                "title" => "text"
            ]
        ],
        SectionKey::ADVERTISE->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::ADVERTISE->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text"
            ],
            Content::ENHANCEMENT->value => [
                "title" => "text",
                "images" => [
                    "advertise_image" => [
                        "size" => "800x600"
                    ]
                ]
            ]
        ],
        SectionKey::BANNER->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::BANNER->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "blue_theme_title"=> "text",
                "first_text" => "text",
                "second_text" => "text",
                "first_icon" => "icon",
                "first_title" => "text",
                "second_icon" => "icon",
                "second_title" => "icon",
                "third_icon" => "icon",
                "third_title" => "icon",
                "btn_name" => "text",
                "btn_url" => "text",
                "video_link" => "text",
                "images" => [
                    "main_image" => [
                        "size" => "593x586"
                    ],
                    "background_image" => [
                         "size" => "2470x1529"
                    ],
                    "first_provider_image" => [
                        "size" => "106x22"
                    ],
                    "second_provider_image" => [
                        "size" => "106x22"
                    ],
                    "third_provider_image" => [
                        "size" => "106x22"
                    ],
                    "fourth_provider_image" => [
                        "size" => "106x22"
                    ]
                ]
            ],
            Content::ENHANCEMENT->value => [
                "images" => [
                    "blue_theme_image" => [
                        "size" => "800x160"
                    ]
                ]
            ]
        ],
        SectionKey::BLOG->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::BLOG->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "blue_theme_btn_name" => "text",
                "blue_theme_btn_url" => "text",
            ],
            Content::ENHANCEMENT->value => [
                "title" => "text",
                "images" => [
                    "thumb_image" => [
                        "size" => "800x500"
                    ],
                    "main_image" => [
                        "size" => "1200x500"
                    ]
                ],
                "description" => "textarea-editor",
            ]
        ],
        SectionKey::CHOOSE_US->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::CHOOSE_US->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "images" => [
                    "vector_image" => [
                        "size" => "512x450"
                    ]
                ]
            ],
            Content::ENHANCEMENT->value => [
                "title" => "text",
                "details" => "text",
                "icon"   => "icon"
            ]
        ],
        SectionKey::CRYPTO_PAIRS->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::CRYPTO_PAIRS->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "images" => [
                    "conversion_image" => [
                        "size" => "276x276"
                    ]
                ]
            ]
        ],
        SectionKey::CURRENCY_EXCHANGE->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::CURRENCY_EXCHANGE->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
            ]
        ],
        SectionKey::FAQ->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::FAQ->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "btn_name" => "text",
                "btn_url" => "text",
                "images" => [
                    "bg_image" => [
                        "size" => "385x278"
                    ]
                ]

            ],
            Content::ENHANCEMENT->value => [
                "question" => "text",
                "answer" => "text"
            ]
        ],
        SectionKey::PRICING_PLAN->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::PRICING_PLAN->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text"
            ]
        ],
        SectionKey::MATRIX_PLAN->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::MATRIX_PLAN->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "images" => [
                    "award_image" => [
                        "size" => "36x36"
                    ]
                ]
            ]
        ],
        SectionKey::PROCESS->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::PROCESS->value,
            "limit" => 3,
            Content::FIXED->value => [
                "blue_theme_heading" => "text",
                "blue_theme_sub_heading" => "text",
            ],
            Content::ENHANCEMENT->value => [
                "icon" => "icon",
                "title" => "text",
                "details" => "text"
            ]
        ],
        SectionKey::SERVICE->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::SERVICE->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "images" => [
                    "blue_theme_image" => [
                        "size" => "550x525"
                    ]
                ]
            ],
            Content::ENHANCEMENT->value => [
                "title" => "text",
                "url" => "text",
                "images" => [
                    "service_image" => [
                        "size" => "636x477"
                    ],
                ]
            ]
        ],
        SectionKey::TESTIMONIAL->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::TESTIMONIAL->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "title" => "text",
                "total_reviews" => "text",
                "avg_rating" => "text"
            ],
            Content::ENHANCEMENT->value => [
                "testimonial" => "text",
                "name" => "text",
                "designation" => "text"
            ]
        ],
        SectionKey::FOOTER->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::FOOTER->value,
            Content::FIXED->value => [
                "heading" => "text",
                "news_letter_title" => "text",
                "news_letter" => "text",
                "details" => "text",
                "copy_right_text" => "text",
                "images" => [
                    "footer_vector" => [
                        "size" => "481x481"
                    ],
                    "payment" => [
                        "size" => "583x83"
                    ],
                ],
            ],
        ],
        SectionKey::SIGN_IN->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::SIGN_IN->value,
            Content::FIXED->value => [
                "heading" => "text",
                'title' => "text",
                'details' => "textarea",
                "images" => [
                    "background_image" => [
                        "size" => "1920x1080"
                    ],
                ]
            ]
        ],
        SectionKey::SIGN_UP->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::SIGN_UP->value,
            Content::FIXED->value => [
                "heading" => "text",
                'title' => "text",
                'details' => "textarea",
                "images" => [
                    "background_image" => [
                        "size" => "1920x1080"
                    ],
                ]
            ]
        ],
        SectionKey::CRYPTO_COIN->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::CRYPTO_COIN->value,
            Content::FIXED->value => [
                "images" => [
                    "first_crypto_coin" => [
                        "size" => "450X450"
                    ],
                    "second_crypto_coin" => [
                        "size" => "450X450"
                    ],
                    "third_crypto_coin" => [
                        "size" => "450X450"
                    ],
                    "fourth_crypto_coin" => [
                        "size" => "450X450"
                    ],
                ]
            ]
        ],
        SectionKey::SOCIAL->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::SOCIAL->value,
            Content::FIXED->value => [
                "facebook_icon" => "icon",
                "facebook_url" => "text",
                "twitter_icon" => "icon",
                "twitter_url" => "text",
                "instagram_icon" => "icon",
                "instagram_url" => "text",
                "tiktok_icon" => "icon",
                "tiktok_url" => "text",
                "telegram_icon" => "icon",
                "telegram_url" => "text",
            ],
        ],
        SectionKey::CONTACT->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::CONTACT->value,
            Content::FIXED->value => [
                "heading" => "text",
                "sub_heading" => "text",
                "title" => "text",
                "email" => "text",
                "phone" => "text",
                "address" => "text",
                "images" => [
                    "background_image" => [
                        "size" => "1920x1080"
                    ],
                ]
            ],
        ],
        SectionKey::PAGE->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::PAGE->value,
            Content::ENHANCEMENT->value => [
                "name" => "text",
                "descriptions" => "textarea-editor",
            ],
        ],
        SectionKey::FEATURE->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::FEATURE->value,
            Content::FIXED->value => [
                "heading" => "text",
                'sub_heading' => "text",
                'btn_name' => "text",
                'btn_url' => "text",
                "images" => [
                    "blue_theme_main_image" => [
                        "size" =>  '418x542'
                    ],
                ]
            ],
            Content::ENHANCEMENT->value => [
                "title" => "text",
                "details" => "textarea",
                "icon" => "icon",
            ],
        ],
        SectionKey::COOKIE->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::COOKIE->value,
            Content::FIXED->value => [
                "title" => "textarea",
            ],
        ],
        SectionKey::INVESTMENT_PROFIT->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::INVESTMENT_PROFIT->value,
            Content::FIXED->value => [
                "heading" => "text",
                'sub_heading' => "text",
            ],
        ],
        SectionKey::STAKING_INVESTMENT->value => [
            "isBuilderEnabled" => true,
            "name" => SectionName::STAKING_INVESTMENT->value,
            Content::FIXED->value => [
                "heading" => "text",
                'sub_heading' => "text",
            ],
        ],
    ]
];
return $data;
