<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Enums\User\KycStatus;
use App\Services\SettingService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KYCMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = SettingService::getSetting();

        if(getArrayValue($setting->system_configuration, 'kyc_verification.value', Status::INACTIVE->value) == Status::INACTIVE->value){
            return $next($request);
        }

        $user = Auth::user();

        if ($user->kyc_status == KycStatus::INACTIVE->value) {
            return to_route('user.verify.identity')->with('notify', [['warning', "You need to verify your identity. To do that, please give us the necessary information"]]);
        }

        if ($user->kyc_status == KycStatus::REQUESTED->value) {
            return to_route('user.dashboard')->with('notify', [['warning', "Your KYC verification documents are currently under review. Kindly await approval from the administrator"]]);
        }

        return $next($request);
    }
}
