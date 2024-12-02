<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReferralController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = "Referral list";
        $user = Auth::user();

        return view('user.referral.index', compact(
            'setTitle',
            'user'
        ));
    }
}
