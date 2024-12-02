<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\Email\EmailSmsTemplateName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredRequest;
use App\Jobs\EmailSmsProcessJob;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use App\Services\Payment\WalletService;
use App\Services\UserService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
class AuthenticateController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected UserService $userService,
    )
    {

    }

    public function register(RegisteredRequest $request): JsonResponse
    {
        $referralId = null;

        if($request->has('referral_id') && !is_null($request->input('referral_id'))){
            $referralId = $this->userService->findByUuid($request->input('referral_id'))?->id;
        }

        $user = User::create([
            'uuid' => Str::uuid(),
            'first_name' => $request->input('name'),
            'email' => $request->input('email'),
            'referral_by' => $referralId,
            'password' => Hash::make($request->input('password')),
            'email_verified_at' => now(),
        ]);

        $this->walletService->save($this->walletService->prepParams((int) $user->id));
        $user->notify(new UserRegisteredNotification());

       return ApiJsonResponse::success('Registration Successful', [
           'access_token' => $user->createToken($user->first_name . $user->email . '-AuthToken')->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    /**
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return ApiJsonResponse::success('Login Successfully and create access token ', [
            'access_token' => $user->createToken($user->first_name . $user->email . '-AuthToken')->plainTextToken,
        ]);

    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return ApiJsonResponse::success('Logged out');
    }


    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return ApiJsonResponse::error('Email not found');
        }

        $token = mt_rand(100000, 999999);

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['token' => $token]
        );

        dispatch(new EmailSmsProcessJob($user, [
            'token' => $token,
        ], EmailSmsTemplateName::PASSWORD_RESET_CODE->value));

        return ApiJsonResponse::success('Reset password email sent', $passwordReset);
    }


    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $passwordReset = PasswordReset::where('email', $request->input('email'))
            ->where('token', $request->input('token'))
            ->first();

        if (!$passwordReset){
            return ApiJsonResponse::error('Invalid token', statusCode: 404);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return ApiJsonResponse::error('User not found', statusCode: 404);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        $passwordReset->delete();
        return ApiJsonResponse::success('Password reset successfully');
    }

}
