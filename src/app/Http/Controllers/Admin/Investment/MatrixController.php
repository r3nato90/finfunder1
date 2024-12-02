<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Enums\CommissionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Matrix\PlanRequest;
use App\Services\Investment\CommissionService;
use App\Services\Investment\MatrixInvestmentService;
use App\Services\Investment\MatrixService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatrixController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected MatrixService $matrixService,
        protected MatrixInvestmentService $matrixEnrolledService,
        protected CommissionService $commissionService,
    ){

    }
    /**
     * @return View
     */
    public function create(): View
    {
        $setTitle = __('admin.matrix.page_title.create');

        return view('admin.matrix.create', compact('setTitle'));
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.matrix.page_title.index');
        $plans = $this->matrixService->getPlansByPaginate(with: ['matrixLevel']);

        return view('admin.matrix.index', compact('plans', 'setTitle'));
    }

    /**
     * @param PlanRequest $request
     * @return RedirectResponse
     */
    public function store(PlanRequest $request): RedirectResponse
    {
        $plan = $this->matrixService->save($this->matrixService->prepParams($request));
        $this->matrixService->updatePlanMatrixLevels(
            (array) $request->input('matrix_levels'),
            (int) $plan->id
        );

        return back()->with('notify', [['success', __('admin.matrix.notify.plan.create.success')]]);
    }

    /**
     * @param string $uid
     * @return View
     */
    public function edit(string $uid): View
    {
        $setTitle = __('admin.matrix.page_title.edit');
        $plan =  $this->matrixService->findByUid($uid);

        if(!$plan){
            abort(404);
        }

        $totalAmount = $plan->matrixLevel->sum('amount') + $plan->referral_reward;
        $calculateAmount = $plan->amount - $totalAmount;

        return view('admin.matrix.edit', compact('setTitle', 'plan', 'totalAmount', 'calculateAmount'));
    }

    /**
     * @param PlanRequest $request
     * @param string $uid
     * @return RedirectResponse
     */
    public function update(PlanRequest $request, string $uid): RedirectResponse
    {
        $plan = $this->matrixService->findByUid($uid);
        if(!$plan){
            abort(404);
        }

        $plan->update($this->matrixService->prepParams($request));
        $this->matrixService->updatePlanMatrixLevels(
            (array) $request->input('matrix_levels'),
            (int) $plan->id
        );

        return redirect()->route('admin.matrix.index')->with('notify', [['success', __('admin.matrix.notify.plan.update.success')]]);
    }

    /**
     * Update matrix parameters.
     * @param Request $request
     * @return RedirectResponse
     */
    public function matrixParameters(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'height' => ['required','integer','gt:0', 'max:20'],
            'width' => ['required','integer','gt:0', 'max:20'],
        ]);

        $this->settingService->getSetting()->update([
            'matrix_parameters' => $validatedData,
        ]);

        return back()->with('notify', [['success', __('admin.matrix.notify.parameter.update.success')]]);
    }

    public function matrixEnrol(): View
    {
        $setTitle = __('admin.matrix.page_title.enroll');
        $matrixEnrolled = $this->matrixEnrolledService->getEnrolledByPaginate();

        return view('admin.matrix.enrol', compact(
            'setTitle',
            'matrixEnrolled'
        ));
    }

    public function levelCommissions(): View
    {
        $setTitle = __('admin.matrix.page_title.level');
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::LEVEL, ['user', 'fromUser']);

        return view('admin.matrix.commissions', compact(
            'setTitle',
            'commissions'
        ));
    }

    public function referralCommissions(): View
    {
        $setTitle = __('admin.matrix.page_title.referral');
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::REFERRAL, ['user', 'fromUser']);

        return view('admin.matrix.commissions', compact(
            'setTitle',
            'commissions'
        ));
    }
}
