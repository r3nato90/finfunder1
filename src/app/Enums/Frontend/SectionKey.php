<?php

namespace App\Enums\Frontend;

use App\Enums\EnumTrait;

enum SectionKey: string
{

    use EnumTrait;

    case ABOUT = "about";
    case ADVERTISE = "advertise";
    case BANNER = "banner";
    case BLOG = "blog";
    case CHOOSE_US = "choose_us";
    case CRYPTO_PAIRS = "crypto_pairs";
    case CURRENCY_EXCHANGE= "currency_exchange";
    case FAQ = "faq";
    case PRICING_PLAN = "pricing_plan";
    case MATRIX_PLAN = "matrix_plan";
    case PROCESS = "process";
    case SERVICE = "service";
    case TESTIMONIAL = "testimonial";
    case FOOTER = "footer";
    case SIGN_IN = "sign_in";
    case SIGN_UP = "sign_up";
    case CRYPTO_COIN = "crypto_coin";
    case SOCIAL = "social";
    case CONTACT = 'contact';
    case PAGE = 'page';
    case FEATURE = 'feature';
    case COOKIE = 'cookie';
    case INVESTMENT_PROFIT  = 'investment-profit-calculation';
    case STAKING_INVESTMENT = 'staking-investment';
}
