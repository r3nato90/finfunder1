<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminPasswordReset;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    /**
     * @return View
     */
    public function create():View
    {
        $setTitle = "Password verify";
        return view('admin.auth.verify', compact('setTitle'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function store(Request $request):mixed
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $code = preg_replace('/[ ,]+/', '', trim($request->code));
        $token = AdminPasswordReset::where('token', $code)->first();

        if(!$token){
            $notify[] = ['error', 'An invalid token has been entered'];
            return redirect(route('admin.password.request'))->withNotify($notify);
        }

        $notify[] = ['success', 'You need to change your password.'];
        return redirect()->route('admin.password.reset', $token->uuid)->withNotify($notify);
    }
}
