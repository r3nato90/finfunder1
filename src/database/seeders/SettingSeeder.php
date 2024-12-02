<?php

namespace Database\Seeders;

use App\Enums\Frontend\InputField;
use App\Enums\Frontend\RequiredStatus;
use App\Enums\Status;
use App\Enums\Theme\ThemeName;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        $setting = [
            'sms_gateway_id' => 1,
            'logo' => [
                'dark' => 'dark_logo.png',
                'white' => 'white_logo.png',
                'favicon' => 'favicon.png',
            ],
            'appearance' => [
                'site_title' => "FinFunder",
                'timezone' => 'UTC',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'phone' => '1234567890',
                'email' => 'demo@example.com',
                'address' => '3971 Roden Dr NE',
                'paginate' => '20',
                'copy_right_text' => "© 2024 by FinFunder. All rights reserved.",
            ],
            'theme_setting' => [
                'primary_color' => '#fe710d',
                'secondary_color' => '#fe710d',
                'primary_text_color' => '#150801',
                'secondary_text_color' => '#6a6a6a',
            ],
            'recaptcha_setting' => [
                'registration' => Status::INACTIVE->value,
                'login' => Status::INACTIVE->value,
                'key' => '#fe710d',
                'secret' => '#fe710d',
            ],
            'seo_setting' => [
                'title' => '-',
                'image' => null,
                'keywords' => ['crypto', 'trade'],
                'description' => 'FinFunder',
            ],
            'matrix_parameters' => [
                'height' => 6,
                'width' => 10,
            ],
            'mail_configuration' => [
                'from_name' => "FinFunder",
                'from_email'=> 'noreply@kloudinnovation.com',
                'host' => 'mail.smtp2go.com',
                'port' => '465',
                'encryption' => 'tls',
                'username' => 'demo' ,
                'password' => "demo"
            ],
            'agent_investment_commission' => [
                'fixed_commission'=> [
                    'status' => Status::ACTIVE->value,
                    'bonus' => 5,
                ],
                'percentage_commission'=> [
                    'status' => Status::ACTIVE->value,
                    'bonus' => 5,
                ],
                'performance_based_commission'=> [
                    'status' => Status::ACTIVE->value,
                    'threshold' => 1000,
                    'bonus' => 15,
                ],
                'monthly_team_investment_commission'=> [
                    'status' => Status::ACTIVE->value,
                    'monthly_team_investment' => 100000,
                    'bonus' => 100,
                ]
            ],
            'system_configuration' => [
                'investment_reward' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "Enabling this module allows users to receive rewards for their investments within the system.",
                ],
                'balance_transfer' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "Enabling this module allows users to initiate balance transfers within the system.",
                ],
                'e_pin' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, users won't be able to recharge E-pins on this system.",
                ],
                'withdraw_request' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, users won't be able to submit withdrawal requests in this system.",
                ],
                'binary_trade' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you deactivate the binary trade option, the binary trading feature will be turned off.",
                ],
                'practice_trade' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you deactivate the practice trade option, the practice trading feature will be turned off.",
                ],
                'registration_status' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, new users won't be able to register on this system.",
                ],
                'email_verification' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you deactivate the email verification module, users won't be able to verify their email addresses in this system.",
                ],
                'email_notification' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, users won't receive email notifications in this system.",
                ],
                'sms_notification' => [
                    'value' => \App\Enums\Status::INACTIVE->value,
                    'title' => "If you disable this module, users won't receive SMS notifications in this system.",
                ],
                'kyc_verification' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, users won't undergo KYC verification in this system.",
                ],
                'cookie_activation' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, users won't be able to activate cookies in this system.",
                ],
                'language' => [
                    'value' => \App\Enums\Status::ACTIVE->value,
                    'title' => "If you disable this module, users won't be able to change the system language.",
                ],
            ],
            'social_login' => [
                'google' => [
                    'client_id' => "demo",
                    'client_secret' => "demo",
                    'redirect' => env('APP_URL').'/google/callback',
                    'status' => Status::INACTIVE->value,
                ],
                'facebook' => [
                    'client_id' => "demo",
                    'client_secret' => "demo",
                    'redirect' => env('APP_URL').'/facebook/callback',
                    'status' => Status::INACTIVE->value,
                ],
            ],
            'commissions_charge'=> [
                'investment_transfer_charge' => 1,
                'investment_cancel_charge' => 1,
                'e_pin_charge' => 2,
                'balance_transfer_charge' => 1,
                'binary_trade_commissions' => 1,
                'trade_practice_balance' => 1000,
            ],
            'investment_setting' => [
                'investment' => 1,
                'staking_investment' => 1,
                'matrix' => 1,
                'trade_prediction' => 1,
            ],
            'security' => [
                'application_firewall' => [
                    'attempts' => 5,
                    'frequency' => 60,
                    'period' => 30,
                    'status' => Status::INACTIVE->value
                ],
            ],
            'theme_template_setting' => [
                'currently_active' => ThemeName::DEFAULT_THEME->value,
                'themes' => [
                    ThemeName::DEFAULT_THEME->value => [
                        'title'     => 'Default Theme',
                        'details'   => 'A classic and clean layout with standard colors and design elements.',
                    ],
                    ThemeName::BLUE_THEME->value => [
                        'title'     => 'Blue Theme',
                        'details'   => 'A vibrant theme with shades of blue, providing a modern and refreshing look.',
                    ],
                ],
            ],
            'referral_setting' => [
                [
                    "investment" => Status::ACTIVE->value,
                    "deposit" => Status::ACTIVE->value,
                    "interest_rate" => Status::ACTIVE->value,
                ],
            ],
            'kyc_configuration' => [
                [
                    'field_label' => "Name",
                    'field_type' => InputField::TEXT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => null,
                ],
                [
                    'field_label' => "Gender",
                    'field_type' => InputField::SELECT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => [
                        'Male',
                        'Female',
                        'Other',
                        'Prefer not to say'
                    ],
                ],
                [
                    'field_label' => "Date of Birth",
                    'field_type' => InputField::TEXT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => null,
                ],
                [
                    'field_label' => "Email Address",
                    'field_type' => InputField::TEXT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => null,
                ],
                [
                    'field_label' => "Phone Number",
                    'field_type' => InputField::TEXT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => null,
                ],
                [
                    'field_label' => "Home Address",
                    'field_type' => InputField::TEXT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => null,
                ],
                [
                    'field_label' => "Nationality",
                    'field_type' => InputField::TEXT->value,
                    'is_required' => RequiredStatus::YES->value,
                    'options' => null,
                ],
            ],
            'mail_template' => 'Hello Dear,',
            'sms_template' => 'Hello Dear,',
            'version' => '1.0'
        ];
        Setting::truncate();
        Setting::create($setting);
    }
}
