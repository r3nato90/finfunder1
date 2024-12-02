<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Enums\Referral\ReferralCommissionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayRequest;
use App\Services\Investment\HolidayService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HolidayController extends Controller
{
    public function __construct(protected HolidayService $holidayService)
    {

    }

    public function index(): View
    {
        $setTitle = 'Manage Investment Holidays';
        $holidays = $this->holidayService->getByPaginate();

        return view('admin.holiday.index', compact('setTitle', 'holidays'));
    }

    /**
     * @param HolidayRequest $request
     * @return RedirectResponse
     */
    public function store(HolidayRequest $request): RedirectResponse
    {
        $this->holidayService->save($this->holidayService->prepParams($request));
        return back()->with('notify', [['success', __('Holiday setting has been added successfully')]]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->holidayService->update($request);
        return back()->with('notify', [['success', __('Holiday setting has been updated successfully')]]);
    }


    public function setting(Request $request): RedirectResponse
    {
        $request->validate([
            'holidays' => ['sometimes', 'array'],
        ]);

        $holidays = [];
        if($request->has('holidays')){
            $holidays = $request->input('holidays');
        }

        $setting = SettingService::getSetting();
        $setting->holiday_setting = $holidays;
        $setting->save();

        return back()->with('notify', [['success', __('Weekly holiday setting updated successfully')]]);
    }
}
