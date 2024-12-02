<?php

namespace App\Providers;

use App\Enums\Payment\GatewayCode;
use App\Enums\Status;
use App\Models\Language;
use App\Models\PaymentGateway;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {

        Paginator::useBootstrapFive();
        try {
            DB::connection()->getPdo();
            $setting = SettingService::getSetting();
            $activeTheme = getArrayValue($setting->theme_template_setting, 'currently_active', 'default_theme') ?? 'default_theme';

            view()->share([
                'languages' => Language::get(),
                'setting' => $setting,
            ]);

            SettingService::mail();
            $this->firewall($setting);
            $this->recaptcha($setting);
            $this->paymentGateway();

            Config::set('services', array_map(function ($login) {
                return Arr::except($login, 'status');
            }, $setting->social_login));

        }catch (\Exception $exception){

        }
    }


    protected function firewall(?Setting $setting): void
    {
        if(!$setting){
            return;
        }

        $firewallStatus = getArrayValue($setting->security, 'application_firewall.status') == Status::ACTIVE->value;
        Config::set('firewall.enabled', $firewallStatus);
        Config::set('firewall.middleware.ip.enabled',$firewallStatus);

        Config::set('firewall.middleware.agent.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.agent.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.agent.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.agent.enabled',$firewallStatus);

        Config::set('firewall.middleware.bot.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.bot.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.bot.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.bot.enabled',$firewallStatus);

        Config::set('firewall.middleware.geo.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.geo.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.geo.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.geo.enabled',$firewallStatus);

        Config::set('firewall.middleware.lfi.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.lfi.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.lfi.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.lfi.enabled',$firewallStatus);

        Config::set('firewall.middleware.login.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.login.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.login.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.login.enabled',$firewallStatus);

        Config::set('firewall.middleware.referrer.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.referrer.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.referrer.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.referrer.enabled',$firewallStatus);

        Config::set('firewall.middleware.rfi.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.rfi.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.rfi.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.rfi.enabled',$firewallStatus);

        Config::set('firewall.middleware.sqli.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.sqli.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.sqli.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.sqli.enabled',$firewallStatus);

        Config::set('firewall.middleware.swear.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.swear.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.swear.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.swear.enabled',$firewallStatus);

        Config::set('firewall.middleware.url.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.url.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.url.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
        Config::set('firewall.middleware.url.enabled',$firewallStatus);

        Config::set('firewall.middleware.php.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.php.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.php.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);

        Config::set('firewall.middleware.xss.auto_block.attempts', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.xss.auto_block.frequency', getArrayValue($setting->security, 'application_firewall.attempts'));
        Config::set('firewall.middleware.xss.auto_block.period', (int)getArrayValue($setting->security, 'application_firewall.period') * 60);
    }

    public function paymentGateway(): void
    {
        $paypal = PaymentGateway::where('code', GatewayCode::PAYPAL)->first();
        $coinbaseCommerce = PaymentGateway::where('code', GatewayCode::COINBASE_COMMERCE)->first();
        $flutterWave = PaymentGateway::where('code', GatewayCode::FLUTTER_WAVE)->first();
        $payStack = PaymentGateway::where('code', GatewayCode::PAY_STACK)->first();

        if ($coinbaseCommerce){
            Config::set('coinbase.apiKey', Arr::get($coinbaseCommerce->parameter, 'api_key'));
        }

        if($payStack){
            Config::set('paystack', [
                'publicKey' => Arr::get($payStack->parameter, 'public_key', ''),
                'secretKey' => Arr::get($payStack->parameter, 'secret_key', ''),
                'paymentUrl' => Arr::get($payStack->parameter, 'payment_url', ''),
                'merchantEmail' => Arr::get($payStack->parameter, 'merchant_email', ''),
            ]);
        }

        if($flutterWave){
            Config::set('flutterwave', [
                'publicKey' => Arr::get($flutterWave->parameter, 'public_key', ''),
                'secretKey' => Arr::get($flutterWave->parameter, 'secret_key', ''),
                'secretHash' => Arr::get($flutterWave->parameter, 'secret_hash', ''),
            ]);
        }

        if ($paypal) {
            $paymentParameter = (array) $paypal->parameter ?? [];
            $config = [
                'mode' => Arr::get($paymentParameter, 'environment', 'sandbox'),
                'sandbox' => [
                    'client_id' => Arr::get($paymentParameter, 'client_id', ''),
                    'client_secret' => Arr::get($paymentParameter, 'secret', ''),
                    'app_id' => Arr::get($paymentParameter, 'app_id', ''),
                ],
                'live' => [
                    'client_id' => Arr::get($paymentParameter, 'client_id', ''),
                    'client_secret' => Arr::get($paymentParameter, 'secret', ''),
                    'app_id' => Arr::get($paymentParameter, 'app_id', ''),
                ],
                'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
                'currency' => env('PAYPAL_CURRENCY', 'USD'),
                'notify_url' => env('PAYPAL_NOTIFY_URL', ''),
                'locale' => env('PAYPAL_LOCALE', 'en_US'),
                'validate_ssl' => env('PAYPAL_VALIDATE_SSL', true),
            ];

            Config::set('paypal', $config);
        }
    }


    public function recaptcha(?Setting $setting): void
    {
        if(!$setting){
            return;
        }
        Config::set('recaptchav3',[
            'origin' => 'https://www.google.com/recaptcha',
            'sitekey' => getArrayValue($setting->recaptcha_setting, 'key'),
            'secret' => getArrayValue($setting->recaptcha_setting, 'secret'),
            'locale' => 'en'
        ]);

    }
}
