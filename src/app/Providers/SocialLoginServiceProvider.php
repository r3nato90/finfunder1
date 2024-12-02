<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SocialLoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        try {
            $setting = Setting::first();
            if($setting && $setting->google_login){
                Config::set('services.google', [
                    'client_id' => Arr::get($setting->google_login, 'client_id'),
                    'client_secret' => Arr::get($setting->google_login, 'client_secret'),
                    'redirect' => url('auth/google/callback'),
                ]);
            }
        }catch(\Exception $exception){
        }
    }
}
