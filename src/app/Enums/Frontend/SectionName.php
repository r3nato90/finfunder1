<?php

namespace App\Enums\Frontend;

use App\Enums\EnumTrait;

enum SectionName: string
{
    use EnumTrait;

    case ABOUT = "About Section";
    case ADVERTISE = "Advertise Section";
    case BANNER = "Banner Section";
    case BLOG = "Blog Section";
    case CHOOSE_US = "Choose Us";
    case CRYPTO_PAIRS = "Crypto Pairs";
    case CURRENCY_EXCHANGE= "Currency Exchange";
    case FAQ = "FAQ Section";
    case PRICING_PLAN = "Investment Plan";
    case MATRIX_PLAN = "Matrix Plan";
    case PROCESS = "Process Section";
    case SERVICE = "Service Section";
    case TESTIMONIAL = "Testimonial Section";
    case FOOTER = "Footer Section";
    case SIGN_IN = "Sign In";
    case SIGN_UP = "Sign Up";
    case CRYPTO_COIN = "Crypto Coin";
    case SOCIAL = "Social Section";
    case CONTACT = 'Contact';
    case PAGE = 'Page';
    case FEATURE = 'Feature';
    case COOKIE = 'Cookie';
    case INVESTMENT_PROFIT = 'investment Profit';
    case STAKING_INVESTMENT = 'Staking Investment';

}
