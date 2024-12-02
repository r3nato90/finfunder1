<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Enums\CommissionType;
use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\User\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Matrix\BinaryOptionsRequest;
use App\Jobs\EmailSmsProcessJob;
use App\Models\InvestmentPlan;
use App\Models\User;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\TimeTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BinaryInvestmentController extends Controller
{
    public function __construct(
        protected InvestmentPlanService $investmentPlanService,
        protected InvestmentService $investmentService,
        protected CommissionService $commissionService,
        protected TimeTableService $timeTableService,
    ){

    }
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.binary.page_title.index');
        $binaryInvests = $this->investmentPlanService->getBinaryOptionPlanByPaginate();

        return view('admin.binary.index', compact(
            'setTitle',
            'binaryInvests'
        ));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $setTitle = __('admin.binary.page_title.create');
        $timeTables = $this->timeTableService->getActiveTime();

        return view('admin.binary.create', compact(
            'setTitle',
            'timeTables'
        ));
    }


    /**
     * @param string $uid
     * @return View
     */
    public function edit(string $uid): View
    {
        $setTitle = __('admin.binary.page_title.edit');
        $scheme = $this->investmentPlanService->findByUid($uid);
        $timeTables = $this->timeTableService->getActiveTime();

        return view('admin.binary.edit', compact(
            'setTitle',
            'scheme',
            'timeTables'
        ));
    }

    /**
     * @param BinaryOptionsRequest $request
     * @return RedirectResponse
     */
    public function store(BinaryOptionsRequest $request): RedirectResponse
    {
        $plan = $this->investmentPlanService->save($this->investmentPlanService->prepParams($request));
        $this->notifyUsersIfRequested($request, $plan);

        return back()->with('notify', [['success', __('admin.binary.notify.plan.update.success')]]);
    }


    /**
     * @param BinaryOptionsRequest $request
     * @return RedirectResponse
     */
    public function update(BinaryOptionsRequest $request): RedirectResponse
    {
        $this->investmentPlanService->update($request);
        return redirect()->route('admin.binary.index')->with('notify', [['success', __('admin.binary.notify.plan.update.success')]]);
    }

    public function investment(): View
    {
        $setTitle = __('admin.binary.page_title.investment');
        $investmentLogs = $this->investmentService->getInvestmentLogsByPaginate(with: ['user']);

        return view('admin.binary.investment', compact(
            'setTitle',
            'investmentLogs'
        ));
    }


    /**
     * @return View
     */
    public function dailyCommissions(): View
    {
        $setTitle = __('Investment Profits and Commissions');
        $dailyCommissions = $this->commissionService->getCommissionsOfType(CommissionType::INVESTMENT, ['user']);

        return view('admin.binary.commission', compact(
            'setTitle',
            'dailyCommissions'
        ));
    }


    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('Investment Details');
        $investment = $this->investmentService->findById($id);
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::INVESTMENT, with: ['user'], investmentLogId: $investment->id);

        return view('admin.binary.details', compact(
            'setTitle',
            'commissions',
            'investment',
        ));
    }

    /**
     * @param BinaryOptionsRequest $request
     * @param InvestmentPlan $plan
     * @return void
     */
    protected function notifyUsersIfRequested(BinaryOptionsRequest $request, InvestmentPlan $plan): void
    {
        if ($request->has('notify')){

            $users = User::where('status', Status::ACTIVE->value)
                ->whereNull('email_verified_at')
                ->select('phone', 'email')
                ->get();

            foreach ($users as $user) {
                dispatch(new EmailSmsProcessJob($user, [
                    'name' => $plan->name,
                    'minimum' => shortAmount($plan->minimum),
                    'maximum' => shortAmount($plan->maximum),
                    'amount' => shortAmount($plan->amount),
                    'interest_rate' => shortAmount($plan->interest_rate),
                    'duration' => $plan->duration,
                ], EmailSmsTemplateName::INVESTMENT_PLAN_NOTIFY->value));
            }
        }
    }
}
