<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\Payment\IpnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Installer
Route::prefix('installer')->name('installer.')->group(function () {
    Route::get('/', [InstallerController::class, 'index'])->name('index');
    Route::get('/permissions', [InstallerController::class, 'permissions'])->name('permissions');
    Route::get('/environment', [InstallerController::class, 'environment'])->name('environment');
    Route::post('/environment/save', [InstallerController::class, 'environmentSave'])->name('environment.save');
    Route::get('/applications/{key}', [InstallerController::class, 'application'])->name('application');
    Route::post('/run', [InstallerController::class, 'run'])->name('run');
    Route::get('/success/{key}', [InstallerController::class, 'success'])->name('success');
});

Route::get('cron-run',[\App\Http\Controllers\CronController::class, 'handle'])->name('cron.run');
Route::get('queue-work', function () {
    $cron = \App\Models\Cron::where('code', \App\Enums\CronCode::QUEUE_WORK)->first();
    if ($cron){
        $cron->last_run = \Carbon\Carbon::now();
        $cron->save();
    }
    Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::middleware(['installer','firewall.all'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/trades', [HomeController::class, 'trade'])->name('trade');
    Route::get('/page/{url}', [HomeController::class, 'page'])->name('dynamic.page');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/language-change/{languageId}', [HomeController::class, 'languageChange'])->name('language.change');
    Route::get('/blogs/{id}/details', [HomeController::class, 'blogDetail'])->name('blog.detail');
    Route::post('/subscribes', [HomeController::class, 'subscribe'])->name('subscribe');
    Route::get('/default/images/{size}', [HomeController::class, 'defaultImageCreate'])->name('default.image');
    Route::post('/contact/store', [HomeController::class, 'contactStore'])->name('contact.store');
    Route::get('/quick/{slug}/{id}', [HomeController::class, 'policy'])->name('policy');

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::name('ipn.')->group(function () {
    Route::get('blockchain', [IpnController::class, 'blockchain'])->name('blockchain');
});


require __DIR__.'/auth.php';
