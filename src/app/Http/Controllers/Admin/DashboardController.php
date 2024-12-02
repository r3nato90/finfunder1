<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\UploadedFile;
use App\Enums\Trade\TradeType;
use App\Http\Controllers\Controller;
use App\Models\CryptoCurrency;
use App\Models\Matrix;
use App\Models\Notification;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawMethod;
use App\Services\Investment\InvestmentService;
use App\Services\Payment\DepositService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WithdrawService;
use App\Services\Trade\ActivityLogService;
use App\Services\Trade\CryptoCurrencyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    use UploadedFile;

    public function __construct(
        protected TransactionService $transactionService,
        protected ActivityLogService $activityLogService,
        protected CryptoCurrencyService $cryptoCurrencyService,
        protected InvestmentService $investmentService,
        protected WithdrawService $withdrawService,
        protected DepositService $depositService
    )
    {

    }

    /**
     * @return View
     */
    public function dashboard()
    {
        if(version_compare(config('app.migrate_version'), config('app.app_version'), '>')){
            return redirect()->route('admin.setting.update');
        }

        $setTitle = __('admin.dashboard.page_title.dashboard');

        [$months, $depositMonthAmount, $withdrawMonthAmount] = $this->depositService->monthlyReport();
        $investment = $this->investmentService->getInvestmentReport();

        $deposit = $this->depositService->getReport();
        $withdraw = $this->withdrawService->getReport();
        $cards = $this->getCards();
        $transactions = $this->transactionService->latestTransactions();
        $tradeActivity = $this->activityLogService->recentActivities(TradeType::TRADE, 7, with: ['cryptoCurrency']);
        $cryptoCurrencies = $this->cryptoCurrencyService->getActiveCryptoCurrency();
        [$investmentMonths, $invest, $profit] = $this->investmentService->monthlyReport();

        return view('admin.dashboard', compact(
            'setTitle',
            'investment',
            'deposit',
            'withdraw',
            'transactions',
            'tradeActivity',
            'cryptoCurrencies',
            'cards',
            'depositMonthAmount',
            'withdrawMonthAmount',
            'months',
            'investmentMonths',
            'invest',
            'profit',
        ));
    }

    /**
     * @return View
     */
    public function profile(): View
    {
        $setTitle = __('admin.dashboard.page_title.profile');
        $admin = auth()->guard('admin')->user();

        return view('admin.profile', compact('setTitle', 'admin'));
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

        $admin = Auth::guard('admin')->user();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->username = $request->input('username');
        $admin->image = $request->hasFile('image') ? $this->move($request->file('image')) : $admin->image;
        $admin->save();

        return back()->with('notify', [['success', __('admin.dashboard.notify.profile.success')]]);
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

        $admin = Auth::guard('admin')->user();
        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return back()->with('notify', [['error', 'Password do not match!!']]);
        }

        $admin->password = Hash::make($request->input('password'));
        $admin->save();

        return back()->with('notify', [['success', __('admin.dashboard.notify.password.success')]]);
    }


    /**
     * @return View
     */
    public function notifications(): View
    {
        $setTitle = "All Notifications";
        $notifications = Notification::latest()->paginate(getPaginate());

        DB::table('notifications')->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('admin.notification', compact(
            'setTitle',
            'notifications',
        ));
    }



    /**
     * @return array[]
     */
    protected function getCards(): array
    {
        return [
            [ __('admin.dashboard.content.statistic.users'), User::count(), 'users', 'primary', route('admin.user.index')],
            [ __('admin.dashboard.content.statistic.crypto'), CryptoCurrency::count(), 'coins', 'success', route('admin.crypto.currencies.index')],
            [ __('admin.dashboard.content.statistic.transactions'), Transaction::count(), 'exchange-alt', 'info', route('admin.report.transactions')],
            [ __('admin.dashboard.content.statistic.matrix'), Matrix::count(), 'chart-bar', 'warning', route('admin.matrix.index')],
            [ __('admin.dashboard.content.statistic.gateways'), PaymentGateway::count(), 'credit-card', 'pink', route('admin.payment.gateway.index')],
            [ __('admin.dashboard.content.statistic.withdraw_methods'), WithdrawMethod::count(), 'wallet', 'info', route('admin.withdraw.index')],
        ];
    }

}
