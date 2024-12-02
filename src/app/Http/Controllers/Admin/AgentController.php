<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Payment\NotificationType;
use App\Enums\Payment\Withdraw\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\Jobs\EmailSmsProcessJob;
use App\Models\Agent;
use App\Models\AgentTransaction;
use App\Models\AgentWithdrawLog;
use App\Models\WithdrawLog;
use App\Notifications\WithdrawNotification;
use App\Services\Agent\AgentService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function __construct(protected AgentService $agentService){

    }

    public function index(): View
    {
        $setTitle = 'Manage Agents';
        $agents = $this->agentService->getPaginate();

        return view('admin.agents.index', compact('setTitle', 'agents'));
    }

    public function store(AgentRequest $request): \Illuminate\Http\RedirectResponse
    {
        $agent = $this->agentService->save($this->agentService->prepParams($request));

        dispatch(new EmailSmsProcessJob($agent, [
            'email' => $agent->email,
            'password' => $agent->password,
        ], EmailSmsTemplateName::AGENT_CREDENTIALS->value));

        return back()->with('notify', [['success', __('Agent has been added successfully')]]);
    }


    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'nullable|string'
        ]);

        $agent = Agent::findOrFail($request->id);

        if ($request->filled('email')) {
            $agent->email = $request->input('email');
        }

        if ($request->filled('password')) {
            $agent->password = Hash::make($request->input('password'));
        }

        if ($request->has('status')) {
            $agent->status = $request->input('status');
        }
        $agent->save();
        return back()->with('notify', [['success', __('Agent has been updated successfully')]]);
    }

    public function saveAddSubtract(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'id' => ['required', Rule::exists('agents', 'id')],
            'type' => ['required', Rule::in(Type::values())],
        ]);

        $agent = Agent::findOrFail($request->input('id'));
        $amount = $request->input('amount');
        $type = (int) $request->input('type');

        if ($type === Type::PLUS->value) {
            $agent->balance += $amount;
            $transactionType = Type::PLUS->value;
            $transactionDetails = getCurrencySymbol() . $amount . ' has been added to wallet from admin';
            $notifyMessage = getCurrencySymbol() . $amount . ' has been added to ' . $agent->name . '\'s wallet';
        } else {
            $agent->balance -= $amount;
            $transactionType = Type::MINUS->value;
            $transactionDetails = getCurrencySymbol() . $amount . ' has been subtracted from wallet by admin';
            $notifyMessage = getCurrencySymbol() . $amount . ' has been subtracted from ' . $agent->name . '\'s wallet';
        }

        $agent->save();
        $agentTransaction = new AgentTransaction();
        $agentTransaction->agent_id = $agent->id;
        $agentTransaction->amount = $amount;
        $agentTransaction->post_balance = $agent->balance;
        $agentTransaction->trx = getTrx();
        $agentTransaction->type = $transactionType;
        $agentTransaction->details = $transactionDetails;
        $agentTransaction->save();

        return back()->with('notify', [['success', $notifyMessage]]);
    }

    public function transaction(): View
    {
        $setTitle = 'Manage Transactions';
        $transactions = AgentTransaction::latest()->paginate(getPaginate());

        return view('admin.agents.transaction', compact('setTitle', 'transactions'));
    }

    public function investmentSetting(Request $request): RedirectResponse
    {
        $request->validate([
            'agent_investment_commission' => ['sometimes', 'array'],
            'agent_investment_commission.fixed_commission.status' => ['required', 'string'],
            'agent_investment_commission.fixed_commission.bonus' => ['required', 'numeric', 'gt:0'],
            'agent_investment_commission.percentage_commission.status' => ['required', 'string'],
            'agent_investment_commission.percentage_commission.bonus' => ['required', 'numeric', 'gt:0'],
            'agent_investment_commission.performance_based_commission.status' => ['required', 'string'],
            'agent_investment_commission.performance_based_commission.threshold' => ['required', 'numeric', 'gt:0' ],
            'agent_investment_commission.performance_based_commission.bonus' => ['required', 'numeric', 'gt:0'],
            'agent_investment_commission.monthly_team_investment_commission.status' => ['required', 'string'],
            'agent_investment_commission.monthly_team_investment_commission.monthly_team_investment' => ['required', 'numeric', 'gt:0'],
            'agent_investment_commission.monthly_team_investment_commission.bonus' => ['required', 'numeric', 'gt:0'],
        ]);

        $agentInvestmentCommission = $request->input('agent_investment_commission', []);
        $setting = SettingService::getSetting();
        $setting->agent_investment_commission = $agentInvestmentCommission;
        $setting->save();

        return back()->with('notify', [['success', __('Agent Investment commission setting updated successfully')]]);
    }

    public function withdrawIndex(): View
    {
        $setTitle = __('Agent withdraws');
        $withdrawLogs = AgentWithdrawLog::latest()
            ->with(['withdrawMethod'])
            ->paginate(getPaginate());

        return view('admin.agents.withdraw', compact(
            'setTitle',
            'withdrawLogs'
        ));
    }

    /**
     * @param int $id
     * @return View
     */
    public function withdrawDetails(int $id): View
    {
        $setTitle = __('Agent withdraw details');
        $withdraw = AgentWithdrawLog::findOrFail($id);

        return view('admin.agents.withdraw_details', compact(
            'setTitle',
            'withdraw',
        ));
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @return RedirectResponse
     */
    public function withdrawUpdate(Request $request, int|string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(Status::SUCCESS->value, Status::CANCEL->value)]
        ]);

        $withdraw = AgentWithdrawLog::findOrFail($id);
        $agent = $withdraw->agent ?? null;

        if($agent || $withdraw->status != Status::PENDING->value){
            abort(404);
        }

        if($request->input('status') == Status::CANCEL->value){
            $agent->balance += $withdraw->amount;
            $agent->save();

            $agentTransaction = new AgentTransaction();
            $agentTransaction->agent_id = $agent->id;
            $agentTransaction->amount = $withdraw->amount;
            $agentTransaction->post_balance = $agent->balance;
            $agentTransaction->charge = $withdraw->charge;
            $agentTransaction->trx = getTrx();
            $agentTransaction->type = Type::PLUS->value;
            $agentTransaction->details = 'Withdrawal canceled: Amount returned to agent\'s  account.';
            $agentTransaction->save();
        }

        $withdraw->status = $request->input('status');
        $withdraw->details = $request->input('details');
        $withdraw->save();

        return back()->with('notify', [['success', __('admin.withdraw.notify.update.success')]]);
    }

}
