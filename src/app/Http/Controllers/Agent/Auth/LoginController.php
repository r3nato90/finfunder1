<?php

namespace App\Http\Controllers\Agent\Auth;

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
        $this->middleware('agent.guest')->except('logout');
    }
    /**
     * @return View
     */
    public function login(): View
    {
        $setTitle = "Agent Login";
        return view('agent.auth.login', compact('setTitle'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function authenticate(Request $request): ?RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|exists:agents,email',
            'password' => 'required',
        ]);

        if (Auth::guard('agent')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('agent.dashboard');
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
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('agent.login');
    }
}
