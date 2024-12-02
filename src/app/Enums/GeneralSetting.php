<?php

namespace App\Enums;

enum GeneralSetting: string
{
    use EnumTrait;

    case APPEARANCE = 'appearance';
    case THEME_SETTING = 'theme_setting';
    case RECAPTCHA_SETTING = 'recaptcha_setting';
    case SEO_SETTING = 'seo_setting';
    case MATRIX_PARAMETERS = 'matrix_parameters';
    case MAIL_CONFIGURATION  = 'mail_configuration';
    case SYSTEM_CONFIGURATION = 'system_configuration';
    case SOCIAL_LOGIN = 'social_login';
    case COMMISSION_CHARGE = 'commissions_charge';
    case KYC_CONFIGURATION = 'kyc_configuration';
    case CRYPTO_API = 'crypto_api';
    case SECURITY = 'security';
}
