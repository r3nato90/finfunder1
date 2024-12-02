<?php

namespace App\Http\Controllers\Admin\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\RewardRequest;
use App\Services\Investment\RewardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function __construct(
        protected RewardService $rewardService
    ){

    }

    public function index(): View
    {
        $setTitle = __('User reward setting only for Investment');
        $rewards = $this->rewardService->getByPaginate();

        return view('admin.investment.reward', compact(
            'setTitle',
            'rewards'
        ));
    }


    /**
     * @param RewardRequest $request
     * @return RedirectResponse
     */
    public function store(RewardRequest $request): RedirectResponse
    {
        $this->rewardService->save($this->rewardService->prepParams($request));
        return back()->with('notify', [['success', __('User reward been added successfully')]]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->rewardService->update($request);
        return back()->with('notify', [['success', __('User reward has been updated successfully')]]);
    }
}
