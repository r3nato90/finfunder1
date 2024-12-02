<?php

use App\Http\Controllers\Api\Auth\AuthenticateController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\InvestmentController;
use App\Http\Controllers\Api\User\MatrixController;
use App\Http\Controllers\Api\User\PaymentController;
use App\Http\Controllers\Api\User\RechargeController;
use App\Http\Controllers\Api\User\StakingInvestmentController;
use App\Http\Controllers\Api\User\TradeController;
use App\Http\Controllers\Api\User\WalletController;
use App\Http\Controllers\Api\User\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group( function () {
    Route::post('register', [AuthenticateController::class,'register']);
    Route::post('login', [AuthenticateController::class,'login']);
    Route::post('forgot-password', [AuthenticateController::class,'forgotPassword']);
    Route::post('reset-password', [AuthenticateController::class,'resetPassword']);
});

Route::prefix('settings')->group( function () {
    Route::get('/', [SettingController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/', [HomeController::class, 'userInfo']);

    Route::post('logout', [AuthenticateController::class, 'logout']);
    Route::get('dashboard', [HomeController::class, 'index']);
    Route::get('transactions', [HomeController::class, 'transactions']);
    Route::post('profile-update', [HomeController::class, 'profileUpdate']);
    Route::post('password-update', [HomeController::class, 'passwordUpdate']);

    Route::prefix('investments')->group( function () {
        Route::get('/', [InvestmentController::class, 'index']);
        Route::get('/funds', [InvestmentController::class, 'fund']);
        Route::post('/store', [InvestmentController::class, 'store']);
        Route::post('/make-re-investment', [InvestmentController::class, 'makeReinvestment']);
        Route::post('/complete-investment-transfer', [InvestmentController::class, 'completeInvestmentTransfer']);
        Route::post('/cancel', [InvestmentController::class, 'cancel']);
    });

    Route::prefix('matrix')->group( function () {
        Route::get('/', [MatrixController::class, 'index']);
        Route::post('/store', [MatrixController::class, 'store']);
        Route::get('/investment-rewards', [MatrixController::class, 'investmentReward']);
    });

    Route::prefix('payments')->group( function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::post('/process', [PaymentController::class, 'process']);
        Route::post('/traditional', [PaymentController::class, 'traditionalPaymentApi']);
        Route::post('/success', [PaymentController::class, 'success']);
        Route::get('/deposit-commission', [PaymentController::class, 'depositCommission']);
    });

    Route::prefix('withdraws')->group( function () {
        Route::get('/', [WithdrawController::class, 'index']);
        Route::post('/store', [WithdrawController::class, 'store']);
    });

    Route::prefix('wallets')->group( function () {
        Route::get('/', [WalletController::class, 'index']);
        Route::post('/transfer/own-account', [WalletController::class, 'transferWithinOwnAccount']);
        Route::post('/transfer/other-account', [WalletController::class, 'transferToOtherUser']);
    });

    Route::prefix('insta-pin')->group( function () {
        Route::get('/', [RechargeController::class, 'index']);
        Route::post('/recharge', [RechargeController::class, 'save']);
        Route::post('/generate', [RechargeController::class, 'generate']);
    });

    Route::prefix('trade-prediction')->group( function () {
        Route::get('/', [TradeController::class, 'index']);
        Route::get('/trade/{pair}', [TradeController::class, 'trade']);
        Route::post('/save/{id}', [TradeController::class, 'store']);
        Route::get('/statistics', [TradeController::class, 'statistics']);
        Route::get('/crypto', [TradeController::class, 'crypto']);
    });

    Route::prefix('staking-investment')->group( function () {
        Route::get('/', [StakingInvestmentController::class, 'index']);
        Route::post('/save', [StakingInvestmentController::class, 'store']);
    });
});
