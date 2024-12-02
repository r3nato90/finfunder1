<?php

namespace App\Http\Controllers\Payment;

use App\Concerns\CustomValidation;
use App\Concerns\UploadedFile;
use App\Enums\CommissionType;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\GatewayCode;
use App\Enums\Payment\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentProcessRequest;
use App\Notifications\DepositNotification;
use App\Services\Investment\CommissionService;
use App\Services\Payment\DepositService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Throwable;

class PaymentController extends Controller
{
    use CustomValidation, UploadedFile;
    public function __construct(
        protected PaymentService $paymentService,
        protected DepositService $depositService,
        protected CommissionService $commissionService,
    ){

    }

    public function index(): View
    {
        $setTitle = "Payment Gateway";
        $gateways = $this->paymentService->fetchActivePaymentGateways();
        $deposits = $this->depositService->getUserDepositByPaginated((int)Auth::id(), ['gateway'], Status::INITIATED->value);

        return view('payment.process', compact(
            'setTitle',
            'gateways',
            'deposits',
        ));
    }

    public function commission(): View
    {
        $setTitle = "Referral Deposit Commission Rewards";
        $depositCommissions = $this->commissionService->getCommissionsOfType(CommissionType::DEPOSIT, ['user']);

        return view('payment.commission', compact(
            'setTitle',
            'depositCommissions',
        ));
    }

    public function process(PaymentProcessRequest $request): RedirectResponse
    {
        try {
            $gateway = $this->paymentService->findByCode($request->input('code'));
            if ($request->input('amount') < $gateway->minimum || $request->input('amount') > $gateway->maximum) {
                return back()->with('notify', [['error', 'The investment amount should be between ' . getCurrencySymbol().shortAmount($gateway->minimum) . ' and ' . getCurrencySymbol().shortAmount($gateway->maximum)]]);
            }

            $payment = $this->paymentService->makePayment($gateway, $request, (float) $request->input('amount'));
            if(is_null($payment)){
                return back()->with('notify', [['warning', "$gateway->name Api has issues, please try again later"]]);
            }
            return redirect()->to($payment);

        }catch (\Exception $exception){
            return back()->with('notify', [['warning', $exception->getMessage()]]);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ApiErrorException|Throwable
     */
    public function success(Request $request): RedirectResponse
    {
        $trxId = null;

        if($request->query('gateway_code') == GatewayCode::STRIPE->value){
            $paymentGateway = $this->paymentService->findByCode(GatewayCode::STRIPE->value);
            Stripe::setApiKey(Arr::get($paymentGateway->parameter,'secret_key'));

            $paymentIntent = Session::retrieve($request->query('payment_intent'));
            $trxId = $paymentIntent->metadata['transaction_id'] ?? '';
        }

        if($request->query('gateway_code') == GatewayCode::PAYPAL->value){
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $trxId = $request->query('trx');
            }
        }

        if($request->query('gateway_code') == GatewayCode::COINBASE_COMMERCE->value){
            $trxId = $request->query('trx');
        }

        if($request->query('gateway_code') == GatewayCode::NOW_PAYMENT->value){
            $trxId = $request->query('trx');
        }

        if($request->query('gateway_code') == GatewayCode::COIN_GATE->value){
            $trxId = $request->query('payment_intent');
        }

        if($request->query('gateway_code') == GatewayCode::FLUTTER_WAVE->value){
            $status = request()->status;
            if ($status ==  'successful') {
                $trxId = $request->query('trx');
            }
        }

        if($request->query('gateway_code') == GatewayCode::PAY_STACK->value){
            $trxId = $request->query('trx');
        }

        if (is_null($trxId)) {
            return back()->with('notify', [['error', "Something went wrong with the payment"]]);
        }

        $payment = $this->paymentService->successPayment($trxId);

        if (!$payment) {
            return back()->with('notify', [['error', "Something went wrong with the payment"]]);
        }

        return redirect()->route('user.payment.index')->with('notify', [['success', "Payment has been successful"]]);
    }

    /**
     * @return RedirectResponse
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('user.dashboard');
    }

    public function preview(Request $request): View
    {
        $gateway = $this->paymentService->findByCode($request->query('gateway_code'));
        $setTitle = "{$gateway->name} deposit preview";
        $payment = $this->depositService->findByTrxId($request->query('payment_intent'));

        return view('payment.preview', compact(
            'gateway',
            'payment',
            'setTitle'
        ));
    }

    /**
     * @throws ValidationException
     */
    public function traditional(Request $request): RedirectResponse
    {
        $gateway = $this->paymentService->findByCode($request->input('gateway_code'));
        $deposit = $this->depositService->findByTrxId($request->input('payment_intent'));

        if(!$gateway || !$deposit){
            abort(401);
        }

        $this->validate($request, $this->parameterValidation((array)$gateway->parameter));
        $deposit->meta = $this->paymentService->parameterStoreData(((array)$gateway->parameter));
        $deposit->save();

        $this->paymentService->successPayment($deposit->trx);

        $deposit->notify(new DepositNotification(NotificationType::REQUESTED));
        return redirect()->route('user.payment.index')->with('notify', [['success', "Payment has been successful"]]);
    }



}
