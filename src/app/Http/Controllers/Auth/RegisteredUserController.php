<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredRequest;
use App\Jobs\SendEmailVerificationJob;
use App\Models\Agent;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use App\Providers\RouteServiceProvider;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected UserService $userService,
    )
    {

    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $setTitle = 'Register';
        $referral = $this->userService->getReferral();

        if(!$referral){
            $referral =  $this->getAgentReferral();
        }

        $setting = SettingService::getSetting();
        if (getArrayValue($setting?->system_configuration, 'registration_status.value') != Status::ACTIVE->value) {
            abort(404);
        }

        return view('auth.register', compact('referral', 'setTitle'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(RegisteredRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();

        if (getArrayValue($setting?->system_configuration, 'registration_status.value') != Status::ACTIVE->value) {
            abort(404);
        }

        if (getArrayValue($setting?->recaptcha_setting, 'registration') == Status::ACTIVE->value
            && RecaptchaV3::verify($request->input('g-recaptcha-response')) <= 0.3) {
            return back()->with('notify', [['error', 'Captcha verification failed']]);
        }

        $referral = $this->userService->getReferral();
        $agentReferral = null;
        if(!$referral){
            $agentReferral =  $this->getAgentReferral();
        }

        $user = User::create([
            'uuid' => Str::uuid(),
            'first_name' => $request->input('name'),
            'email' => $request->input('email'),
            'referral_by' => $referral?->id,
            'agent_id' => $agentReferral?->id,
            'password' => Hash::make($request->input('password')),
        ]);

        if (getArrayValue($setting->system_configuration, 'email_verification.value') == Status::ACTIVE->value){
            SendEmailVerificationJob::dispatch($user);
        }else{
            $user->email_verified_at = now();
            $user->save();
        }

        $this->walletService->save($this->walletService->prepParams((int) $user->id));
        $user->notify(new UserRegisteredNotification());

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }


    public function getAgentReferral(): ?Agent
    {
        $referral = null;

        if (session()->get('reference_uuid')) {
            $referral = Agent::where('uuid', session()->get('reference_uuid'))->first();
        }

        return $referral;
    }
}
