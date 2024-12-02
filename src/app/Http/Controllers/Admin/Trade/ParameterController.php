<?php

namespace App\Http\Controllers\Admin\Trade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trade\ParameterRequest;
use App\Services\Trade\ParameterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParameterController extends Controller
{
    public function __construct(protected ParameterService $tradeParameterService){
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.trade_parameter.page_title.index');
        $tradeParameters = $this->tradeParameterService->getTradeParameter();

        return view('admin.trade.parameter.index', compact('setTitle', 'tradeParameters'));
    }

    /**
     * @param ParameterRequest $request
     * @return RedirectResponse
     */
    public function store(ParameterRequest $request): RedirectResponse
    {
        $this->tradeParameterService->save($this->tradeParameterService->prepParams($request));
        return back()->with('notify', [['success', __('admin.trade_parameter.notify.create.success')]]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->tradeParameterService->update($request);
        return back()->with('notify', [['success', __('admin.trade_parameter.notify.update.success')]]);
    }
}
