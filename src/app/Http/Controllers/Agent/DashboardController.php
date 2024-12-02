<?php

namespace App\Http\Controllers\Agent;

use App\Concerns\UploadedFile;
use App\Enums\Investment\Status;
use App\Http\Controllers\Controller;
use App\Models\AgentTransaction;
use App\Models\InvestmentLog;
use App\Services\Investment\InvestmentService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use UploadedFile;
    public function __construct(
        protected InvestmentService $investmentService,
    ){

    }
    public function dashboard(): View
    {
        $setTitle = 'Manage Agent Dashboard';

        $report = [
            'months' => collect(),
            'invest_month_amount' => collect(),
        ];

        $startOfLast12Months = Carbon::now()->subMonths(11)->startOfMonth();

        $agentId = auth()->guard('agent')->user()->id;
        $logs = InvestmentLog::where('created_at', '>=', $startOfLast12Months)
            ->where('status', Status::INITIATED->value)
            ->whereHas('user', fn ($query) => $query->where('agent_id', $agentId))
            ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') as months, SUM(amount) as invest_amount")
            ->groupBy('months')
            ->get();

        $last12Months = collect(CarbonPeriod::create($startOfLast12Months, '1 month', Carbon::now()->endOfMonth()))
            ->map(function ($date) {
                return $date->format('F-Y');
            });

        // Process data
        $last12Months->each(function ($month) use (&$report, $logs) {
            $logDataForMonth = $logs->firstWhere('months', $month);

            $report['months']->push($month);
            $report['invest_month_amount']->push(getAmount(optional($logDataForMonth)->invest_amount));
        });

        $months = $report['months']->values()->all();
        $invest = $report['invest_month_amount']->values()->all();

        return view('agent.dashboard', compact(
            'setTitle',
            'months',
            'invest',
        ));
    }


    /**
     * @return View
     */
    public function profile(): View
    {
        $setTitle = __('Agent Profile');
        $agent = auth()->guard('agent')->user();

        return view('agent.profile', compact('setTitle', 'agent'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function profileUpdate(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);

        $agent = Auth::guard('agent')->user();
        $agent->name = $request->input('name');
        $agent->email = $request->input('email');
        $agent->username = $request->input('username');
        $agent->image = $request->hasFile('image') ? $this->move($request->file('image'), getFilePath()) : $agent->image;
        $agent->save();

        return back()->with('notify', [['success', __('Agent profile has been updated')]]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function passwordUpdate(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $admin = Auth::guard('agent')->user();
        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return back()->with('notify', [['error', 'Password do not match!!']]);
        }

        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        return back()->with('notify', [['success', __('admin.dashboard.notify.password.success')]]);
    }

    public function transactionLog(): View
    {
         $setTitle = 'Transaction Log';
         $agentId = auth()->guard('agent')->user()->id;
         $transactions = AgentTransaction::where('agent_id', $agentId)->latest()->paginate(getPaginate());

         return view('agent.transaction_log', compact('setTitle', 'transactions'));
    }

    public function investmentLog(): View
    {
        $setTitle = 'Investment Log';
        $investmentLogs = InvestmentLog::whereHas('user', function ($query) {
            $query->where('agent_id', auth()->guard('agent')->id());
        })->latest()->paginate(getPaginate());

        return view('agent.investment_log', compact('setTitle', 'investmentLogs'));
    }

}
