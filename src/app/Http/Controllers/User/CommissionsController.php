<?php

namespace App\Http\Controllers\User;

use App\Enums\CommissionType;
use App\Http\Controllers\Controller;
use App\Services\Investment\CommissionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommissionsController extends Controller
{
    public function __construct(protected CommissionService $commissionService)
    {

    }

    public function index(): View
    {
        $setTitle = "Level Commissions";

        $userId = (int)Auth::id();
        $commissions = $this->commissionService->getCommissionsOfType(CommissionType::LEVEL, with: ['fromUser'], userId: $userId);

        return view('user.commissions.index', compact(
            'setTitle',
            'commissions',
        ));
    }


    public function rewards(): View
    {
        $setTitle = "Referral Commissions";

        $userId = (int)Auth::id();
        $rewards = $this->commissionService->getCommissionsOfType(CommissionType::REFERRAL, with: ['fromUser'], userId: $userId);

        return view('user.commissions.rewards', compact(
            'setTitle',
            'rewards',
        ));
    }


}
