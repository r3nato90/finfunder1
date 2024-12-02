<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollMatrixRequest;
use App\Services\Investment\MatrixInvestmentService;
use App\Services\Investment\MatrixService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MatrixController extends Controller
{
    public function __construct(
        protected MatrixService  $matrixService,
        protected WalletService  $walletService,
        protected MatrixInvestmentService $matrixInvestmentService,
        protected UserService $userService,
    ){

    }

    public function index(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::MATRIX->name)) == 0){
            abort(404);
        }

        $setTitle = "Matrix";
        $userId = (int)Auth::id();
        $matrixLog = $this->matrixInvestmentService->findByUserId($userId);

        return view('user.matrix.index', compact(
            'setTitle',
            'matrixLog'
        ));
    }

    /**
     * @param EnrollMatrixRequest $request
     * @return RedirectResponse
     */
    public function store(EnrollMatrixRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::MATRIX->name)) == 0){
            abort(404);
        }

        try{
            $user = $this->userService->findById((int)Auth::id());
            $plan = $this->matrixService->findByUid($request->input('uid'));
            $this->matrixInvestmentService->executeEnrolledScheme($request, $plan, $user);
        }catch (\Exception $exception){
            return back()->with('notify', [['error', $exception->getMessage()]]);
        }

        return back()->with('notify', [['success', "The Matrix scheme has been enrolled."]]);
    }
}
