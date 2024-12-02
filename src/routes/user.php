<?php

use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\CommissionsController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\MatrixController;
use App\Http\Controllers\User\RechargeController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\StakingInvestmentController;
use App\Http\Controllers\User\TradeController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::prefix('users/')->name('user.')->middleware(['auth', 'verified', 'firewall.all', 'installer'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/settings', [HomeController::class, 'setting'])->name('setting');
    Route::get('/transactions',[HomeController::class, 'transactions'])->name('transaction');
    Route::get('/find',[HomeController::class, 'findUser'])->name('find.user');
    Route::get('/investment-rewards',[InvestmentController::class, 'investmentReward'])->name('reward');

    //Identity
    Route::get('/verify-identity', [HomeController::class, 'verifyIdentity'])->name('verify.identity');
    Route::post('/store-identity', [HomeController::class, 'storeIdentity'])->name('store.identity');

    //Referrals
    Route::prefix('referrals')->name('referral.')->group(function () {
        Route::get('', [ReferralController::class, 'index'])->name('index');
    });

    //Referrals
    Route::prefix('commissions')->name('commission.')->group(function () {
        Route::get('', [CommissionsController::class, 'index'])->name('index');
        Route::get('referral-rewards', [CommissionsController::class, 'rewards'])->name('rewards');
    });

    // Wallet
    Route::prefix('wallet-top-up')->name('wallet.')->group(function () {
        Route::get('', [WalletController::class, 'index'])->name('index');
        Route::post('own-account/transfer', [WalletController::class, 'transferWithinOwnAccount'])->name('transfer.own-account');
        Route::post('other-account/transfer', [WalletController::class, 'transferToOtherUser'])->name('transfer.other-account');
    });

    //Trade
    Route::prefix('trades')->name('trade.')->group(function () {
        Route::get('', [TradeController::class, 'index'])->name('index');
        Route::get('binary/{id}', [TradeController::class, 'trade'])->name('binary');
        Route::get('practice/{id}', [TradeController::class, 'practice'])->name('practice');
        Route::post('store/{id}', [TradeController::class, 'store'])->name('store');
        Route::get('logs', [TradeController::class, 'tradeLog'])->name('tradelog');
        Route::get('practices/logs', [TradeController::class, 'practiceLog'])->name('practicelog');
    });

    //Investments
    Route::prefix('investments')->name('investment.')->group(function () {
        Route::get('', [InvestmentController::class, 'index'])->name('index');
        Route::get('funds', [InvestmentController::class, 'funds'])->name('funds');
        Route::get('profit-statistics', [InvestmentController::class, 'profitStatistics'])->name('profit.statistics');
        Route::post('store', [InvestmentController::class, 'store'])->name('store');
        Route::post('make/re-investment', [InvestmentController::class, 'makeReinvestment'])->name('make.re-investment');
        Route::post('cancel', [InvestmentController::class, 'cancel'])->name('cancel');
        Route::post('complete-profitable', [InvestmentController::class, 'completeInvestmentTransfer'])->name('complete.profitable');
    });

    Route::prefix('staking-investment')->name('staking-investment.')->group(function () {
        Route::get('', [StakingInvestmentController::class, 'index'])->name('index');
        Route::post('/store', [StakingInvestmentController::class, 'store'])->name('store');
    });

    // Matrix
    Route::prefix('matrix')->name('matrix.')->group(function () {
        Route::get('', [MatrixController::class, 'index'])->name('index');
        Route::post('enroll-matrix', [MatrixController::class, 'store'])->name('store');
    });

    //Withdraw
    Route::prefix('cash-out')->name('withdraw.')->middleware(['kyc'])->group(function () {
        Route::get('/', [WithdrawController::class, 'index'])->name('index');
        Route::post('/process', [WithdrawController::class, 'process'])->name('process');
        Route::get('/preview/{uid}', [WithdrawController::class, 'preview'])->name('preview');
        Route::post('/make-success/{uid}', [WithdrawController::class, 'makeSuccess'])->name('success');
    });


    Route::prefix('insta-pin-recharge')->name('recharge.')->group(function () {
        Route::get('/', [RechargeController::class, 'index'])->name('index');
        Route::post('/save', [RechargeController::class, 'save'])->name('save');
        Route::post('/generate', [RechargeController::class, 'generate'])->name('generate');
    });

    //payment-process
    Route::prefix('payment/')->name('payment.')->group(function () {
        Route::get('deposits', [PaymentController::class, 'index'])->name('index');
        Route::get('deposits-commissions', [PaymentController::class, 'commission'])->name('commission');
        Route::post('process', [PaymentController::class, 'process'])->name('process');
        Route::get('success', [PaymentController::class, 'success'])->name('success');
        Route::get('cancel', [PaymentController::class, 'cancel'])->name('cancel');
        Route::get('preview', [PaymentController::class, 'preview'])->name('preview');
        Route::put('traditional', [PaymentController::class, 'traditional'])->name('traditional');
    });
});
