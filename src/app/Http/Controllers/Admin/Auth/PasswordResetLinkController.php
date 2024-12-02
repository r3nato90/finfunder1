<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\Email\EmailSmsTemplateName;
use App\Http\Controllers\Controller;
use App\Jobs\EmailSmsProcessJob;
use App\Mail\GlobalMail;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return View
     */
    public function create():View
    {
        $setTitle = "Forgot Password";
        return view('admin.auth.forgot-password', compact('setTitle'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $admin =  Admin::where('email', $request->input('email'))->firstOrFail();
        AdminPasswordReset::where('email', $request->input('email'))->delete();

        $reset = AdminPasswordReset::create([
            'uuid' => Str::uuid(),
            'email' => $request->input('email'),
            'token' => randomGenerateNumber()
        ]);

        $replacer = [
            'code' => $reset->token,
            'time' => $reset->created_at,
        ];

        $mailContent = mail_content(EmailSmsTemplateName::ADMIN_PASSWORD_RESET_CODE->value);
        Mail::to($admin->email)->send(new GlobalMail($mailContent['subject'],text_replacer(getArrayValue($mailContent,'email_content'), $replacer)));

        $notify[] = ['success', 'You have successfully received a password reset code via email'];
        return redirect(route('admin.password.verify'))->withNotify($notify);
    }
}
