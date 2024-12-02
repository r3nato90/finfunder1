<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * @param string $uid
     * @return View
     */
    public function create(string $uid):View
    {
        $token = AdminPasswordReset::where('uuid', $uid)->firstOrFail();
        return view('admin.auth.reset-password', compact('token'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'uuid' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $resetToken = AdminPasswordReset::where('email', $request->input('email'))
            ->where('uuid', $request->input('uuid'))
            ->first();

        if(!$resetToken){
            $notify[] = ['error', 'An invalid token has been entered'];
            return redirect(route('password.request'))->withNotify($notify);
        }

        Admin::where('email', $request->input('email'))->update([
            'password' =>  Hash::make($request->input('password')),
        ]);

        $resetToken->delete();

        $notify[] = ['success', 'Password changed successfully'];
        return redirect(route('admin.login'))->withNotify($notify);

    }
}
