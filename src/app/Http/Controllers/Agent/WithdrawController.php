<?php

namespace App\Http\Controllers\Agent;

use App\Concerns\CustomValidation;
use App\Enums\Payment\Withdraw\MethodStatus;
use App\Enums\Payment\Withdraw\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawProcessRequest;
use App\Models\AgentTransaction;
use App\Models\AgentWithdrawLog;
use App\Models\Wallet;
use App\Models\WithdrawLog;
use App\Models\WithdrawMethod;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawGatewayService;
use App\Services\Payment\WithdrawService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WithdrawController extends Controller
{
    use CustomValidation;

    public function __construct(
        protected WithdrawService $withdrawService,
        protected WithdrawGatewayService $withdrawGatewayService
    ){

    }

    public function withdrawNow(): View
    {
        $setTitle = "Withdraw Now";
        $withdrawMethods = $this->withdrawGatewayService->fetchActiveWithdrawMethod();

        return view('agent.withdraw.now', compact(
            'setTitle',
            'withdrawMethods',
        ));
    }


    public function index(): View
    {
        $setTitle = "Withdraw Logs";
        $agentId = auth()->guard('agent')->user()->id;

        $withdrawLogs = AgentWithdrawLog::where('agent_id', $agentId)
            ->latest()
            ->with(['withdrawMethod'])
            ->paginate(getPaginate());

        return view('agent.withdraw.index', compact(
            'setTitle',
            'withdrawLogs',
        ));
    }

    public function process(WithdrawProcessRequest $request)
    {
        $withdrawMethod = $this->withdrawGatewayService->findById($request->integer('id'));

        if(!$withdrawMethod){
            abort(404);
        }

        $amount = $request->input('amount');
        $agent = auth()->guard('agent')->user();

        if($request->input('amount') > $agent->balance){
            return back()->with('notify', [['error', 'Your request amount is larger then your current balance.']]);
        }

        $withdrawLog = $this->save(
            $this->prepParams($withdrawMethod, $request)
        );

        return redirect()->route('agent.withdraw.preview', $withdrawLog->uid);
    }


    /**
     * @param string $uid
     * @return View
     */
    public function preview(string $uid): View
    {
        $withdrawLog = AgentWithdrawLog::where('uid', $uid)
            ->where('status', Status::INITIATED->value)
            ->orderBy('id', 'desc')
            ->first();

        if(!$withdrawLog){
            abort(404);
        }

        $setTitle = 'Withdraw preview';
        return view('agent.withdraw.preview', compact(
            'setTitle',
            'withdrawLog',
            'uid',
        ));
    }


    /**
     * @param Request $request
     * @param string $uid
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function makeSuccess(Request $request, string $uid): RedirectResponse
    {
        $withdrawLog =  AgentWithdrawLog::where('uid', $uid)
            ->where('status', Status::INITIATED->value)
            ->orderBy('id', 'desc')
            ->first();

        if(!$withdrawLog){
            abort(404);
        }

        $gateway = $withdrawLog->withdrawMethod;
        if (!$gateway ||  $gateway->status == MethodStatus::INACTIVE->value) {
            abort(404);
        }

        $this->validate($request, $this->parameterValidation((array)$gateway->parameter));
        $agent = auth()->guard('agent')->user();

        if ($withdrawLog->amount > $agent->balance) {
            return back()->with('notify', [['error', 'Your request amount is larger then your current balance.']]);
        }

        $agent->balance -= $withdrawLog->amount;
        $agent->save();

        $this->execute($withdrawLog, $gateway, $request);
        return redirect(route('agent.withdraw.index'))->with('notify', [['success', 'Withdraw request sent successfully.']]);
    }


    /**
     * @param AgentWithdrawLog $withdrawLog
     * @param WithdrawMethod $withdrawMethod
     * @param Request $request
     * @return void
     */
    public function execute(AgentWithdrawLog $withdrawLog, WithdrawMethod $withdrawMethod, Request $request)
    {
        $agent = auth()->guard('agent')->user();

        $withdrawLog->status = Status::PENDING->value;
        $withdrawLog->meta = $request->only(array_keys($withdrawMethod->parameter));
        $withdrawLog->save();

        $agentTransaction = new AgentTransaction();
        $agentTransaction->agent_id = $agent->id;
        $agentTransaction->amount = $withdrawLog->amount;
        $agentTransaction->post_balance = $agent->balance;
        $agentTransaction->charge = $withdrawLog->charge;
        $agentTransaction->trx = getTrx();
        $agentTransaction->type = Type::MINUS->value;
        $agentTransaction->details = "Withdraw ".shortAmount($withdrawLog->final_amount)." ".$withdrawLog->currency." via ".$withdrawLog->withdrawMethod->name;
        $agentTransaction->save();
    }


    /**
     * @param WithdrawMethod $withdrawMethod
     * @param Request $request
     * @return array
     */
    public function prepParams(WithdrawMethod $withdrawMethod, Request $request): array
    {
        $agentId = auth()->guard('agent')->user()->id;
        $amount = $request->input('amount');
        $charge = $withdrawMethod->fixed_charge + ($amount * $withdrawMethod->percent_charge / 100);
        $afterCharge = $amount - $charge;

        return [
            'uid' => Str::uuid(),
            'withdraw_method_id' => $withdrawMethod->id,
            'agent_id' => $agentId,
            'currency' => $withdrawMethod->currency,
            'rate' => $withdrawMethod->rate,
            'amount' => $amount,
            'charge' => $charge,
            'final_amount' => $afterCharge * $withdrawMethod->rate,
            'after_charge' => $afterCharge,
            'trx' => getTrx(),
            'status' => Status::INITIATED->value,
        ];
    }


    /**
     * @param array $data
     * @return AgentWithdrawLog
     */
    public function save(array $data): AgentWithdrawLog
    {
        return AgentWithdrawLog::create($data);
    }
}
