<?php

namespace App\Http\Middleware;

use App\Enums\RegistrationStatus;
use App\Services\SettingService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegistrationAllowMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $setting = SettingService::getSetting();

        if (getArrayValue($setting->system_configuration, 'registration_status.value') == RegistrationStatus::DISABLE->value) {
            return back()->with('notify', [['warning', "The registration process is currently disabled."]]);
        }

        return $next($request);
    }
}
