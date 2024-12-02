<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Payment\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthenticatedController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
    ){
    }

    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function handleFacebookCallback()
    {
        try {
            $auth = Socialite::driver('facebook')->user();
            $facebookUser = User::where('facebook_id', $auth->id)->first();

            if ($facebookUser){
                Auth::login($facebookUser);
                return redirect(RouteServiceProvider::HOME);
            }

            $user = User::create([
                'uuid' => Str::uuid(),
                'first_name' => $auth->name ?? '',
                'email' => $auth->email,
                'facebook_id' => $auth->id,
                'email_verified_at' => now(),
            ]);

            $this->walletService->save($this->walletService->prepParams((int) $user->id));

            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);

        } catch (\Exception $e) {
            return redirect()->route('home');
        }
    }
}
