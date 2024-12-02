<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Trade\TradeType;
use App\Http\Controllers\Controller;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\MatrixInvestmentService;
use App\Services\Investment\MatrixService;
use App\Services\Payment\TransactionService;
use App\Services\Trade\ActivityLogService;
use App\Services\Trade\CryptoCurrencyService;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService,
        protected InvestmentService $investmentService,
        protected InvestmentPlanService $investmentPlanService,
        protected ActivityLogService $activityLogService,
        protected CryptoCurrencyService $cryptoCurrencyService,
        protected MatrixService $matrixService,
        protected MatrixInvestmentService $matrixInvestmentService,
    )
    {

    }

    public function transactions(): View
    {
        $setTitle = __('admin.report.page_title.transaction');
        $transactions = $this->transactionService->getTransactions(with: ['user']);

        return view('admin.statistic.transaction', compact(
            'setTitle',
            'transactions'
        ));
    }


    public function investment(): View
    {
        $setTitle = __('admin.report.page_title.investment');

        [$months, $invest, $profit] = $this->investmentService->monthlyReport();
        [$days, $amount] = $this->investmentService->dayReport();
        $investment = $this->investmentService->getInvestmentReport();
        $investmentPlans = $this->investmentPlanService->getActivePlan(with: ['investmentLogs']);
        $investmentLogs = $this->investmentService->latestInvestments(['plan'], 10);

        return view('admin.statistic.investment', compact(
            'setTitle',
            'investment',
            'investmentPlans',
            'investmentLogs',
            'days',
            'amount',
            'months',
            'invest',
            'profit'
        ));
    }

    /**
     * @param int|string $uid
     * @return View
     */
    public function investmentLogsByPlan(int|string $uid): View
    {
        $investmentPlan = $this->investmentPlanService->findByUid($uid);

        if(!$investmentPlan){
            abort(404);
        }

        $setTitle = __('admin.binary.page_title.investment_plan', ['plan_name' => ucfirst($investmentPlan->name)]);
        $investmentLogs = $this->investmentService->getInvestmentLogsByPaginate(planId: $investmentPlan->id);

        return view('admin.binary.investment', compact(
            'setTitle',
            'investmentLogs',
        ));
    }


    /**
     * @param int|string $id
     * @return View
     */
    public function tradeLogsByCrypto(int|string $id): View
    {
        $crypto = $this->cryptoCurrencyService->findById($id);
        if(!$crypto){
            abort(404);
        }

        $setTitle = __('admin.trade_activity.page_title.trade_crypto', ['crypto' => ucfirst($crypto->name)]);
        $trades = $this->activityLogService->getByPaginate(TradeType::TRADE, $crypto->id);

        return view('admin.trade.index', compact('setTitle', 'trades'));
    }


    public function trade(): View
    {
        $setTitle = __('admin.report.page_title.trade');

        [$days, $amount] = $this->activityLogService->dayReport();
        $trade = $this->activityLogService->getTradeReport();
        $latestTradeLogs = $this->activityLogService->recentActivities(TradeType::TRADE, with: ['user', 'cryptoCurrency']);
        $coins = $this->cryptoCurrencyService->getActiveCoinReport(['trade']);

        return view('admin.statistic.trade', compact(
            'setTitle',
            'trade',
            'latestTradeLogs',
            'coins',
            'days',
            'amount',
        ));
    }

    public function matrix(): View
    {
        $setTitle = __('admin.report.page_title.matrix');

        [$months, $invest] = $this->matrixInvestmentService->monthlyReport();
        $matrixPlans = $this->matrixService->getActivePlan(with: ['matrixEnrolled']);
        $matrixInvest = $this->matrixInvestmentService->getMatrixReport();
        $latestMatrixLogs = $this->matrixInvestmentService->latestMatrix(['user'], 10);

        return view('admin.statistic.matrix', compact(
            'setTitle',
            'matrixPlans',
            'latestMatrixLogs',
            'matrixInvest',
            'months',
            'invest'
        ));
    }
}
