<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'logo',
        'sms_gateway_id',
        'appearance',
        'matrix_parameters',
        'system_configuration',
        'theme_setting',
        'recaptcha_setting',
        'seo_setting',
        'mail_configuration',
        'social_login',
        'commissions_charge',
        'crypto_api',
        'kyc_configuration',
        'security',
        'sms_template',
        'mail_template',
        'referral_setting',
        'investment_setting',
        'theme_template_setting',
        'version'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'logo' => 'json',
        'appearance' => 'json',
        'theme_setting' => 'json',
        'recaptcha_setting' => 'json',
        'seo_setting' => 'json',
        'matrix_parameters' => 'json',
        'mail_configuration' => 'json',
        'system_configuration' => 'json',
        'social_login' => 'json',
        'commissions_charge' => 'json',
        'crypto_api' => 'json',
        'kyc_configuration' => 'json',
        'security' => 'json',
        'referral_setting' => 'json',
        'holiday_setting' => 'json',
        'investment_setting' => 'json',
        'agent_investment_commission' => 'json',
        'theme_template_setting' => 'json',
    ];
}
