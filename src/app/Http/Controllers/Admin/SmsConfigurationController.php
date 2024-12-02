<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\SmsGateway;
use App\Models\EmailSmsTemplate;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class SmsConfigurationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.notification.page_title.sms.index');

        $smsGateways = SmsGateway::latest()->paginate(getPaginate());
        return view('admin.sms.index', compact('setTitle', 'smsGateways'));
    }


    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        $setTitle = __('admin.notification.page_title.sms.edit');
        $smsGateway = SmsGateway::findOrFail($id);

        return view('admin.sms.edit', compact('setTitle', 'smsGateway'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id): mixed
    {
        $this->validate($request, [
            "sms_method"    => "required|array|min:1",
            "sms_method.*"  => "required|string|distinct|min:1",
            "status" => "required|in:1,0",
        ]);
        $smsGateway = SmsGateway::findOrFail($id);
        if(!array_diff_key((array)$request->input('sms_method'), (array)$smsGateway->credential) === false){
            $notify[] = ['error', 'Invalid Credential key'];
            return back()->withNotify($notify);
        }
        $credential = [];
        if($request->has('sms_method')){
            foreach ($request->input('sms_method') as $key => $value){
                $credential[$key]  = Arr::get((array)$request->input('sms_method'), $key);
            }
        }
        $smsGateway->update([
            'credential' => $credential,
            'status' => $request->input('status'),
        ]);

        return back()->with('notify', [['success', __('admin.notification.notify.update.success')]]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function send(Request $request): mixed
    {
        $request->validate([
            'sms_gateway_id' => 'required|exists:sms_gateways,id'
        ]);

        $setting = SettingService::getSetting();
        $setting->sms_gateway_id = $request->input('sms_gateway_id');
        $setting->update();

        return back()->with('notify', [['success', __('admin.notification.notify.send.success')]]);
    }
}
