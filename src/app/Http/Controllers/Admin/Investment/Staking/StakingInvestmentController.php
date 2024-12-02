<?php

namespace App\Http\Controllers\Admin\Investment\Staking;

use App\Http\Controllers\Controller;
use App\Http\Requests\StakingPlanRequest;
use App\Services\Investment\Staking\StakingInvestmentService;
use App\Services\Investment\Staking\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StakingInvestmentController extends Controller
{
    public function __construct(
        protected PlanService              $planService,
        protected StakingInvestmentService $investmentService,
    )
    {

    }

    public function investment(): View
    {
        $setTitle = "Staking Investments";
        $investments = $this->investmentService->getPaginate();

        return view('admin.investment.staking.invest', compact('setTitle', 'investments'));
    }

    public function index(): View
    {
        $setTitle = 'Investment Staking';
        $stakingPlans = $this->planService->getByPaginate();

        return view('admin.investment.staking.index', compact('setTitle', 'stakingPlans'));
    }

    /**
     * @param StakingPlanRequest $request
     * @return RedirectResponse
     */
    public function store(StakingPlanRequest $request): RedirectResponse
    {
        $this->planService->save($this->planService->prepParams($request));
        return back()->with('notify', [['success', __('Staking investment plan has been added successfully')]]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->planService->update($request);
        return back()->with('notify', [['success', __('Staking investment plan has been updated successfully')]]);
    }
}
