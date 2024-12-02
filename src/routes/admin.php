<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\EmailConfigurationController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\Investment\BinaryInvestmentController;
use App\Http\Controllers\Admin\Investment\HolidayController;
use App\Http\Controllers\Admin\Investment\MatrixController;
use App\Http\Controllers\Admin\Investment\PinGenerateController;
use App\Http\Controllers\Admin\Investment\ReferralController;
use App\Http\Controllers\Admin\Investment\RewardController;
use App\Http\Controllers\Admin\Investment\Staking\StakingInvestmentController;
use App\Http\Controllers\Admin\Investment\TimetableController;
use App\Http\Controllers\Admin\InvestmentSettingController;
use App\Http\Controllers\Admin\ManualPaymentGatewayController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PluginConfigurationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SmsConfigurationController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\Trade\ActivityController;
use App\Http\Controllers\Admin\Trade\CryptoCurrencyController;
use App\Http\Controllers\Admin\Trade\ParameterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\WithdrawMethodController;
use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('installer')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', [LoginController::class, 'login'])->name('login');
        Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
        Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

        Route::get('verify', [VerifyEmailController::class, 'create'])->name('password.verify');
        Route::post('verify', [VerifyEmailController::class, 'store'])->name('password.verify.update');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('reset.password.update');
    });

    Route::middleware(['admin', 'demo'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        //Admin Profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [DashboardController::class, 'profile'])->name('profile');
            Route::post('/update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
            Route::get('/password', [DashboardController::class, 'password'])->name('password');
            Route::post('/password/update', [DashboardController::class, 'passwordUpdate'])->name('password.update');
            Route::get('/notifications/', [DashboardController::class, 'notifications'])->name('notification');
        });

        //Statistic - Reports
        Route::prefix('statistic-reports')->name('report.')->group(function () {
            Route::get('/transactions', [StatisticController::class, 'transactions'])->name('transactions');
            Route::get('/investments', [StatisticController::class, 'investment'])->name('investment');
            Route::get('/investments/{planId}/plans', [StatisticController::class, 'investmentLogsByPlan'])->name('investment.plans');
            Route::get('/trades/{cryptoId}/crypto-currencies', [StatisticController::class, 'tradeLogsByCrypto'])->name('trade.crypto');
            Route::get('/trades', [StatisticController::class, 'trade'])->name('trade');
            Route::get('/matrix', [StatisticController::class, 'matrix'])->name('matrix');
        });

        //User
        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/identity-logs', [UserController::class, 'identity'])->name('identity');
            Route::put('/identity-update', [UserController::class, 'identityUpdate'])->name('identity.update');
            Route::put('/{uid}/update', [UserController::class, 'update'])->name('update');
            Route::get('/{id}/detail', [UserController::class, 'details'])->name('details');
            Route::put('/add-subtract/balance', [UserController::class, 'saveAddSubtractBalance'])->name('add-subtract.balance');
            Route::get('/login-users/{id}',[UserController::class, 'loginAsUser'])->name('login');
            Route::get('/investments/{id}',[UserController::class, 'investment'])->name('investment');
            Route::get('/trades/{id}',[UserController::class, 'trade'])->name('trade');
            Route::get('/matrix-enrolled/{id}',[UserController::class, 'matrix'])->name('matrix.enrolled');
            Route::get('/deposits/{id}',[UserController::class, 'deposit'])->name('deposit');
            Route::get('/withdraws/{id}',[UserController::class, 'withdraw'])->name('withdraw');
            Route::get('/level-commissions/{id}',[UserController::class, 'level'])->name('level');
            Route::get('/referral-commissions/{id}',[UserController::class, 'referral'])->name('referral');
            Route::get('/referral/tree-views/{id}',[UserController::class, 'referralTree'])->name('referral.tree');
            Route::get('/investment-network/statistics/{id}',[UserController::class, 'statistic'])->name('statistic');
            Route::get('/transactions/{id}',[UserController::class, 'transactions'])->name('transaction');
        });

        //Matrix
        Route::prefix('matrix')->name('matrix.')->group(function () {
            Route::get('/', [MatrixController::class, 'index'])->name('index');
            Route::get('/create', [MatrixController::class, 'create'])->name('create');
            Route::get('/{uid}/edit', [MatrixController::class, 'edit'])->name('edit');
            Route::post('/{uid}/update', [MatrixController::class, 'update'])->name('update');
            Route::post('/store', [MatrixController::class, 'store'])->name('store');
            Route::post('/parameters', [MatrixController::class, 'matrixParameters'])->name('parameters');
            Route::get('/enrolled', [MatrixController::class, 'matrixEnrol'])->name('enrol');
            Route::get('/level-commissions', [MatrixController::class, 'levelCommissions'])->name('level.commissions');
            Route::get('/referral-commissions', [MatrixController::class, 'referralCommissions'])->name('referral.commissions');
        });

        //Binary
        Route::prefix('investments')->name('binary.')->group(function () {
            Route::get('/', [BinaryInvestmentController::class, 'investment'])->name('investment');
            Route::get('/plans', [BinaryInvestmentController::class, 'index'])->name('index');
            Route::get('/create', [BinaryInvestmentController::class, 'create'])->name('create');
            Route::get('/{uid}/edit', [BinaryInvestmentController::class, 'edit'])->name('edit');
            Route::post('/update', [BinaryInvestmentController::class, 'update'])->name('update');
            Route::post('/store', [BinaryInvestmentController::class, 'store'])->name('store');
            Route::get('/commissions', [BinaryInvestmentController::class, 'dailyCommissions'])->name('daily.commissions');
            Route::get('/details/{id}', [BinaryInvestmentController::class, 'details'])->name('details');

            //Referrals
            Route::prefix('referrals')->name('referral.')->group(function (){
                Route::get('/', [ReferralController::class, 'index'])->name('index');
                Route::post('/update', [ReferralController::class, 'update'])->name('update');
                Route::post('/setting', [ReferralController::class, 'setting'])->name('setting');
            });

            // Time-tables
            Route::prefix('time-tables/')->name('timetable.')->group(function () {
                Route::get('/', [TimetableController::class, 'index'])->name('index');
                Route::post('/store', [TimetableController::class, 'store'])->name('store');
                Route::post('/update', [TimetableController::class, 'update'])->name('update');
            });

            // Holiday-settings
            Route::prefix('holiday-settings/')->name('holiday-setting.')->group(function () {
                Route::get('/', [HolidayController::class, 'index'])->name('index');
                Route::post('/store', [HolidayController::class, 'store'])->name('store');
                Route::post('/update', [HolidayController::class, 'update'])->name('update');
                Route::post('/setting', [HolidayController::class, 'setting'])->name('setting');
            });

            // Staking Investment
            Route::prefix('staking-plans/')->name('staking.plan.')->group(function () {
                Route::get('/', [StakingInvestmentController::class, 'index'])->name('index');
                Route::post('/store', [StakingInvestmentController::class, 'store'])->name('store');
                Route::post('/update', [StakingInvestmentController::class, 'update'])->name('update');
            });

            //Rewards
            Route::prefix('rewards/')->name('reward.')->group(function () {
                Route::get('/', [RewardController::class, 'index'])->name('index');
                Route::post('/store', [RewardController::class, 'store'])->name('store');
                Route::post('/update', [RewardController::class, 'update'])->name('update');
            });

            Route::get('/staking-investments', [StakingInvestmentController::class, 'investment'])->name('staking.investment');
        });

        // Investment Setting
        Route::name('investment.setting.')->group(function () {
            Route::get('/investments-setting', [InvestmentSettingController::class, 'index'])->name('index');
            Route::post('/investments-setting/update', [InvestmentSettingController::class, 'update'])->name('update');
        });

        //Pin generate
        Route::prefix('pin-generate')->name('pin.')->group(function () {
            Route::get('/', [PinGenerateController::class, 'index'])->name('index');
            Route::post('/store', [PinGenerateController::class, 'store'])->name('store');
        });

        //Trade Setting
        Route::prefix('trades')->name('trade.')->namespace('Trade')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/practices', [ActivityController::class, 'practice'])->name('practice');

            //Parameters
            Route::prefix('parameters')->name('parameter.')->group(function () {
                Route::get('/', [ParameterController::class, 'index'])->name('index');
                Route::post('/store', [ParameterController::class, 'store'])->name('store');
                Route::post('/update', [ParameterController::class, 'update'])->name('update');
            });
        });

        //Crypto-currencies
        Route::prefix('crypto-currencies')->name('crypto.currencies.')->group(function () {
            Route::get('/', [CryptoCurrencyController::class, 'index'])->name('index');
            Route::post('/update', [CryptoCurrencyController::class, 'update'])->name('update');
        });

        //Deposits
        Route::prefix('deposits')->name('deposit.')->group(function () {
            Route::get('/',[DepositController::class, 'index'])->name('index');
            Route::get('/{trx}/details',[DepositController::class, 'details'])->name('details');
            Route::put('/update/{id}',[DepositController::class, 'update'])->name('update');
            Route::get('/commissions',[DepositController::class, 'commissions'])->name('commission');
            Route::get('/download/{fileName}',[DepositController::class, 'download'])->name('download');
        });

        //Payment Method
        Route::prefix('automatic-gateways')->name('payment.gateway.')->group(function () {
            Route::get('/',[PaymentGatewayController::class, 'index'])->name('index');
            Route::get('/edit/{id}',[PaymentGatewayController::class, 'edit'])->name('edit');
            Route::post('/update/{id}',[PaymentGatewayController::class, 'update'])->name('update');
        });

        //Manual Payment Method
        Route::prefix('traditional-gateways')->name('manual.gateway.')->group(function () {
            Route::get('/', [ManualPaymentGatewayController::class, 'index'])->name('index');
            Route::get('/create', [ManualPaymentGatewayController::class, 'create'])->name('create');
            Route::post('/store', [ManualPaymentGatewayController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ManualPaymentGatewayController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ManualPaymentGatewayController::class, 'update'])->name('update');
        });

        //Settings
        Route::prefix('settings')->name('setting.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::get('/system', [SettingController::class, 'system'])->name('system');
            Route::get('/automation', [SettingController::class, 'automation'])->name('automation');
            Route::get('/cache/clear', [SettingController::class, 'cacheClear'])->name('cache.clear');
            Route::get('/systems/configuration', [SettingController::class, 'configuration'])->name('system.configuration');
            Route::get('/commissions-charges', [SettingController::class, 'commissions'])->name('commissions.charge');
            Route::get('/crypto-api', [SettingController::class, 'crypto'])->name('crypto');
            Route::get('/kyc-setting', [SettingController::class, 'kyc'])->name('kyc');
            Route::get('/application-update', [SettingController::class, 'application'])->name('application');
            Route::get('/languages', [SettingController::class, 'language'])->name('language');
            Route::get('/system-updates', [SettingController::class, 'systemUpdate'])->name('update');
            Route::post('/system-migrate', [SettingController::class, 'systemMigrate'])->name('migrate');
        });

        //System-security
        Route::prefix('system-security')->name('security.')->group(function () {
            Route::get('/', [SettingController::class, 'security'])->name('index');
            Route::get('/blocked-ip', [SettingController::class, 'blockIp'])->name('block.ip');
            Route::get('/firewall-logs', [SettingController::class, 'firewall'])->name('firewall');
        });

        //General Setting
        Route::prefix('general/settings')->name('general.')->group(function () {
            Route::get('/', [SettingController::class, 'general'])->name('index');
            Route::post('/update', [SettingController::class, 'update'])->name('update');
            Route::post('/logo-updates', [SettingController::class, 'updateLogo'])->name('logo.update');
        });

        // Theme Setting
        Route::prefix('themes')->name('theme.')->group(function () {
            Route::get('/', [SettingController::class, 'themeIndex'])->name('index');
            Route::post('/update', [SettingController::class, 'themeUpdate'])->name('update');
        });

        //plugin configuration
        Route::prefix('plugins')->name('plugin.')->group(function () {
            Route::get('/', [PluginConfigurationController::class, 'index'])->name('index');
            Route::post('/update', [PluginConfigurationController::class, 'update'])->name('update');
        });

        // Manage Withdraw
        Route::prefix('withdraws')->name('withdraw.')->group(function () {
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::get('/{id}/details', [WithdrawController::class, 'details'])->name('details');
            Route::post('/{id}/update', [WithdrawController::class, 'update'])->name('update');
        });

        // Manage Agent
        Route::prefix('agents')->name('agent.')->group(function () {
            Route::get('/', [AgentController::class, 'index'])->name('index');
            Route::post('/store', [AgentController::class, 'store'])->name('store');
            Route::post('/update', [AgentController::class, 'update'])->name('update');
            Route::put('/add-subtract/balance', [AgentController::class, 'saveAddSubtract'])->name('add-subtract.balance');
            Route::get('/transactions', [AgentController::class, 'transaction'])->name('transaction');
            Route::put('/investment-setting', [AgentController::class, 'investmentSetting'])->name('investment.setting');
            Route::get('/withdraws', [AgentController::class, 'withdrawIndex'])->name('withdraw.index');
            Route::get('/withdraw-details/{id}', [AgentController::class, 'withdrawDetails'])->name('withdraw.details');
            Route::post('/withdraw-update/{id}', [AgentController::class, 'withdrawUpdate'])->name('withdraw.update');
        });

        //Withdraw Method
        Route::prefix('withdraw-gateways')->name('withdraw.method.')->group(function () {
            Route::get('/', [WithdrawMethodController::class, 'index'])->name('index');
            Route::get('/create', [WithdrawMethodController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [WithdrawMethodController::class, 'edit'])->name('edit');
            Route::post('/store', [WithdrawMethodController::class, 'store'])->name('store');
            Route::post('/update/{id}', [WithdrawMethodController::class, 'update'])->name('update');
        });

        //Email
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/save', [NotificationController::class, 'save'])->name('save');
            Route::get('/templates', [NotificationController::class, 'template'])->name('template');
            Route::get('/templates/edit/{id}', [NotificationController::class, 'edit'])->name('edit');
            Route::post('/templates/update/{id}', [NotificationController::class, 'update'])->name('update');
        });

        //Mail
        Route::prefix('mail-gateway')->name('mail.')->group(function () {
            Route::get('/', [EmailConfigurationController::class, 'index'])->name('index');
            Route::post('/update', [EmailConfigurationController::class, 'update'])->name('update');
            Route::post('/test', [EmailConfigurationController::class, 'test'])->name('test');
        });

        //SMS
        Route::prefix('sms-gateway')->name('sms.gateway.')->group(function () {
            Route::get('/index', [SmsConfigurationController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [SmsConfigurationController::class, 'edit'])->name('edit');
            Route::post('/update/{id}',[SmsConfigurationController::class, 'update'])->name('update');
            Route::put('/send', [SmsConfigurationController::class, 'send'])->name('send');
        });

        //Pages
        Route::prefix('pages')->name('pages.')->group(function () {
            //Menus
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::post('/update', [MenuController::class, 'update'])->name('update');
            Route::post('/delete', [MenuController::class, 'delete'])->name('delete');
            Route::get('/{url}/sections', [MenuController::class, 'sectionSortable'])->name('section.sortable');
            Route::post('/{id}/sections/update', [MenuController::class, 'updateSection'])->name('section.update');
        });

        //Frontend Sections
        Route::prefix('frontend-sections')->name('frontend.section.')->group(function () {
            Route::get('{key}', [FrontendController::class, 'index'])->name('index');
            Route::post('/save/{key}', [FrontendController::class, 'save'])->name('save');
            Route::get('/contents/{key}/{id?}', [FrontendController::class, 'getContent'])->name('content');
            Route::post('/delete/', [FrontendController::class, 'delete'])->name('delete');
        });

        //Subscribers
        Route::prefix('subscribers')->name('subscriber.')->group(function () {
            Route::get('/', [SubscriberController::class, 'index'])->name('index');
            Route::get('/contacts', [SubscriberController::class, 'contacts'])->name('contact');
            Route::post('/send', [SubscriberController::class, 'send'])->name('send');
        });

        //Languages
        Route::controller('LanguageController')->prefix('languages')->name('language.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/delete', 'delete')->name('delete');
            Route::post('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/import/{id}', 'import')->name('import');
            Route::post('/store/key/{id}', 'storeLanguageJsonFile')->name('store.key');
            Route::post('/delete/key/{id}', 'deleteLanguageJsonFile')->name('delete.key');
            Route::post('/update/key/{id}', 'updateLanguageJsonFile')->name('update.key');
        });
    });
});




