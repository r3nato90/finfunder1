<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommissionType;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\NotificationType;
use App\Http\Controllers\Controller;
use App\Notifications\DepositNotification;
use App\Services\Investment\CommissionService;
use App\Services\Payment\DepositService;
use App\Services\Payment\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepositController extends Controller
{
    public function __construct(
        protected DepositService $depositService,
        protected PaymentService $paymentService,
        protected CommissionService $commissionService,
    )
    {

    }

    /**
     * @return View
     */
    public function index(): View
    {
        $setTitle = __('admin.deposit.page_title.index');
        $deposits = $this->depositService->getDeposit(with: ['user', 'gateway']);

        return view('admin.deposit.index', compact(
            'deposits',
            'setTitle'
        ));
    }

    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('admin.deposit.page_title.details');
        $deposit = $this->depositService->findById($id);

        if(!$deposit){
            abort(404);
        }

        return view('admin.deposit.details', compact(
            'setTitle',
            'deposit',
        ));
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @return RedirectResponse
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(Status::SUCCESS->value, Status::CANCEL->value)]
        ]);

        $deposit = $this->depositService->findById($id);

        if(!$deposit){
            abort(404);
        }

        if($request->input('status') == Status::SUCCESS->value){
            $this->paymentService->successPayment($deposit->trx);
        }else{
            $deposit->status = Status::CANCEL->value;
            $deposit->save();

            $deposit->notify(new DepositNotification(NotificationType::REJECTED));
        }

        return back()->with('notify', [['success', __('admin.deposit.notify.update.success')]]);
    }


    /**
     * @return View
     */
    public function commissions(): View
    {
        $setTitle = __('Referral Deposit Commission Rewards');
        $depositCommissions = $this->commissionService->getCommissionsOfType(CommissionType::DEPOSIT, ['user']);

        return view('admin.deposit.commission', compact(
            'setTitle',
            'depositCommissions'
        ));
    }

    public function download(string $fileName): bool|int
    {
        $fileName = base64_decode($fileName);
        $fullPath = 'assets/files/' . $fileName;

        if (!file_exists($fullPath)) {
            return false;
        }

        $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($fullPath);

        header("Content-Disposition: attachment; filename=\"" . Str::random() . ".$ext\"");
        header("Content-Type: $mimetype");
        header("Content-Length: " . filesize($fullPath));

        readfile($fullPath);
        return true;
    }


}
