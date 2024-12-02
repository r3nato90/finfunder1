<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }
    /**
     * @return View
     */
    public function login(): View
    {
        $setTitle = "Admin Login";
        return view('admin.auth.login', compact('setTitle'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function authenticate(Request $request): ?RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|exists:admins,email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            if(version_compare(config('app.migrate_version'), config('app.app_version'), '>')){
                return redirect()->route('admin.setting.update');
            }

            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function logout(Request $request): Redirector|RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
