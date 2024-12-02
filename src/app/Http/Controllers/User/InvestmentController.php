<?php

namespace App\Http\Controllers\User;

use App\Enums\CommissionType;
use App\Enums\Investment\InvestmentRage;
use App\Enums\Investment\Status;
use App\Enums\Payment\NotificationType;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Http\Requests\InvestmentReturnRequest;
use App\Http\Requests\ReInvestmentRequest;
use App\Models\InvestmentUserReward;
use App\Notifications\InvestmentLogNotification;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\InvestmentService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InvestmentController extends Controller
{
    public function __construct(
        protected InvestmentPlanService   $investmentPlanService,
        protected InvestmentService       $investmentService,
        protected WalletService           $walletService,
        protected CommissionService       $commissionService,
    ){
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $setTitle = "Enhancing Capital through Binary Investments";
        return view('user.investment.index', compact(
           'setTitle',
        ));
    }


    /**
     * @return View
     */
    public function funds(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $setTitle = "Investment Records";
        $userId = (int)Auth::id();
        $investmentLogs = $this->investmentService->getInvestmentLogsByPaginate(with: ['plan'], userId: $userId);

        return view('user.investment.funds', compact(
            'setTitle',
            'investmentLogs',
        ));
    }


    public function profitStatistics(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $setTitle = "Investment Profits and Commissions";
        $userId = (int)Auth::id();
        [$months, $invest, $profit] = $this->investmentService->monthlyReport($userId);
        $investmentReport = $this->investmentService->getInvestmentReport($userId);
        $investmentPlans = $this->investmentPlanService->getActivePlan(with: ['investmentLogs'], userId: $userId);
        $profitLogs = $this->commissionService->getCommissionsOfType(CommissionType::INVESTMENT, userId: $userId);

        return view('user.investment.profit', compact(
            'setTitle',
            'profitLogs',
            'months',
            'invest',
            'profit',
            'investmentReport',
            'investmentPlans',
        ));
    }

    /**
     * @param InvestmentRequest $request
     * @return RedirectResponse
     */
    public function store(InvestmentRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $binaryPlan = $this->investmentPlanService->findByUid($request->input('uid'));
        $currentInvestmentLog = $this->investmentService->findCurrentInvestmentLog((int)Auth::id(), (int)$binaryPlan->id, Status::INITIATED);

        if($currentInvestmentLog){
            return back()->with('notify', [['warning', "You're already enrolled in this plan. Consider investing in a different one."]]);
        }

        $wallet = Auth::user()->wallet;
        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);

        if($request->input('amount') > Arr::get($account, 'balance')){
            return back()->with('notify', [['warning', "Your primary account balance is insufficient for this investment."]]);
        }

        if($binaryPlan->type == InvestmentRage::RANGE->value){
            if ($request->input('amount') < $binaryPlan->minimum || $request->input('amount') > $binaryPlan->maximum) {
                return back()->with('notify', [['warning', 'The investment amount should be between ' . getCurrencySymbol().shortAmount($binaryPlan->minimum) . ' and ' . getCurrencySymbol().shortAmount($binaryPlan->maximum)]]);
            }
        }else{
            if ($request->input('amount') != $binaryPlan->amount) {
                return back()->with('notify', [['warning', 'The investment amount should be between ' . getCurrencySymbol().shortAmount($binaryPlan->amount)]]);
            }
        }

        $this->investmentService->executeInvestment($request->input('amount'), $wallet, $binaryPlan);
        return back()->with('notify', [['success', "Investment has been added successfully"]]);
    }

    /**
     * @param ReInvestmentRequest $request
     * @return RedirectResponse
     */
    public function makeReinvestment(ReInvestmentRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $investmentLog = $this->investmentService->findByUid($request->input('uid'));
        if ($investmentLog->status != Status::PROFIT_COMPLETED->value){
            return back()->with('notify', [['warning', "The investment log provided is invalid."]]);
        }

        $wallet = Auth::user()->wallet;
        $this->investmentService->ensureUserOwnership($investmentLog->user);

        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);
        $investmentAmount = $investmentLog->amount + $request->input('amount', 0);

        if($investmentAmount > Arr::get($account, 'balance')){
            return back()->with('notify', [['warning', "Your primary account balance is insufficient for this investment."]]);
        }

        $details = 'Investment completed. Amount returned for re-investment: '.getCurrencySymbol().($investmentLog->amount);
        $this->investmentService->investmentReturnAmount($investmentLog->amount, $investmentLog, Status::COMPLETED, $details, true);
        $this->investmentService->executeInvestment($investmentAmount, $wallet, $investmentLog->plan);

        $investmentLog->notify(new InvestmentLogNotification(NotificationType::RE_INVEST));
        return back()->with('notify', [['success', "Re-investment has been created successfully"]]);
    }

    /**
     * @param InvestmentReturnRequest $request
     * @return RedirectResponse
     */
    public function completeInvestmentTransfer(InvestmentReturnRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $investmentLog = $this->investmentService->findValidInvestmentLog($request, Status::PROFIT_COMPLETED);
        $this->investmentService->ensureUserOwnership($investmentLog->user);

        $amount =  $investmentLog->amount;
        $details = 'Investment Completed: '.getCurrencySymbol().($amount).' added to primary wallet';
        $this->investmentService->investmentReturnAmount($amount, $investmentLog, Status::COMPLETED, $details);
        $this->investmentService->agentCalculateCommission($investmentLog);

        $investmentLog->notify(new InvestmentLogNotification(NotificationType::COMPLETE));
        return back()->with('notify', [['success', "Investment has been transfer Funding successfully"]]);
    }


    /**
     * @param InvestmentReturnRequest $request
     * @return RedirectResponse
     */
    public function cancel(InvestmentReturnRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 0){
            abort(404);
        }

        $investmentLog = $this->investmentService->findValidInvestmentLog($request, Status::INITIATED);
        $this->investmentService->ensureUserOwnership($investmentLog->user);

        $setting = SettingService::getSetting();
        $amount =  calculateCommissionCut($investmentLog->amount, getArrayValue($setting->commissions_charge, 'investment_cancel_charge'));
        $details = 'Investment Cancelled & Refunded';
        $this->investmentService->investmentReturnAmount($amount, $investmentLog, Status::CANCELLED, $details);

        $investmentLog->notify(new InvestmentLogNotification(NotificationType::CANCEL));
        return back()->with('notify', [['success', "Investment has been cancelled successfully"]]);
    }


    public function investmentReward(): View
    {
        $id = Auth::user()->reward_identifier;
        $reward = InvestmentUserReward::find($id);
        $setTitle = "Investment Reward Badges & Level: " . ($reward ? $reward->level : 'N/A');
        $setting = SettingService::getSetting();

        if (getArrayValue($setting->system_configuration, 'investment_reward.value') != \App\Enums\Status::ACTIVE->value) {
            abort(404);
        }

        $investmentUserRewards = InvestmentUserReward::where('status', \App\Enums\Status::ACTIVE->value)->get();
        return view('user.investment_reward', compact('setTitle', 'investmentUserRewards'));
    }
}
