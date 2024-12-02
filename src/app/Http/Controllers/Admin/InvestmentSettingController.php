<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestmentSettingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('Investment Setting');
        return view('admin.investment.setting', compact(
            'setTitle'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['sometimes', 'array'],
        ]);

        $investmentSetting = [];
        if($request->has('type')){
            $investmentSetting = $request->input('type');
        }

        $setting = SettingService::getSetting();
        $setting->investment_setting = $investmentSetting;
        $setting->save();

        return back()->with('notify', [['success', __('Investment setting has been updated successfully')]]);
    }
}
