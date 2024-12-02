<?php

use App\Http\Controllers\Agent\Auth\LoginController;
use App\Http\Controllers\Agent\Auth\NewPasswordController;
use App\Http\Controllers\Agent\Auth\PasswordResetLinkController;
use App\Http\Controllers\Agent\Auth\VerifyEmailController;
use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::namespace('Agent')->prefix('agent')->name('agent.')->middleware('installer')->group(function () {
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

    Route::middleware(['agent', 'demo'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/transaction-logs', [DashboardController::class, 'transactionLog'])->name('transaction-logs');
        Route::get('/investment-logs', [DashboardController::class, 'investmentLog'])->name('investment-logs');

        Route::prefix('profile')->group(function () {
            Route::get('/', [DashboardController::class, 'profile'])->name('profile');
            Route::post('/update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
            Route::get('/password', [DashboardController::class, 'password'])->name('password');
            Route::post('/password/update', [DashboardController::class, 'passwordUpdate'])->name('password.update');
        });

        //Withdraw
        Route::prefix('withdraws')->name('withdraw.')->group(function () {
            Route::get('/now', [WithdrawController::class, 'withdrawNow'])->name('now');
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::post('/process', [WithdrawController::class, 'process'])->name('process');
            Route::get('/preview/{uid}', [WithdrawController::class, 'preview'])->name('preview');
            Route::post('/make-success/{uid}', [WithdrawController::class, 'makeSuccess'])->name('success');
        });
    });
});
