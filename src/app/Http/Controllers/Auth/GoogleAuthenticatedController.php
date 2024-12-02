<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Payment\WalletService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthenticatedController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
    ){
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $auth = Socialite::driver('google')->user();
            $googleUser = User::where('google_id', $auth->id)->first();

            if ($googleUser){
                Auth::login($googleUser);
                return redirect(RouteServiceProvider::HOME);
            }

            $user = User::create([
                'uuid' => Str::uuid(),
                'first_name' => $auth->name ?? '',
                'email' => $auth->email,
                'google_id' => $auth->id,
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
