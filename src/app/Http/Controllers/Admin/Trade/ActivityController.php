<?php

namespace App\Http\Controllers\Admin\Trade;

use App\Enums\Trade\TradeType;
use App\Http\Controllers\Controller;
use App\Services\Trade\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __construct(protected ActivityLogService $activityLogService){

    }
    const TRADE_INDEX_PAGE = 'admin.trade.index';

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $setTitle = __('admin.trade_activity.page_title.index');
        $trades = $this->activityLogService->getByPaginate(tradeType: TradeType::TRADE, with: ['user', 'cryptoCurrency']);

        return view(self::TRADE_INDEX_PAGE, compact('setTitle', 'trades'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function practice(Request $request): View
    {
        $setTitle = "Practice trade logs";
        $trades = $this->activityLogService->getByPaginate(tradeType: TradeType::PRACTICE, with: ['user', 'cryptoCurrency']);

        return view(self::TRADE_INDEX_PAGE, compact('setTitle', 'trades'));
    }
}
