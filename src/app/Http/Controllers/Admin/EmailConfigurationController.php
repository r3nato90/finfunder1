<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GlobalMail;
use App\Services\SettingService;
use App\Http\Requests\EmailConfigurationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailConfigurationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.notification.page_title.mail.index');
        return view('admin.email.index', compact('setTitle'));
    }

    /**
     * @param EmailConfigurationRequest $request
     * @return RedirectResponse
     */
    public function update(EmailConfigurationRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();
        $setting->update([
            'mail_configuration' =>  $request->input('mail_configuration'),
        ]);

        return back()->with('notify', [['success', 'Email Configuration Has Been Updated']]);
    }


    public function test(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required',
        ]);

        try {
            Mail::to($request->input('email'))->send(new GlobalMail($request->input('subject'), $request->input('content')));
            return back()->with('notify', [['success', 'Email has Been Sent']]);
        }catch (\Exception $exception){
            return back()->with('notify', [['error', $exception->getMessage()]]);
        }
    }
}
