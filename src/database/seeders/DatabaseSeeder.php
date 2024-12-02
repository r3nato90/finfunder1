<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Deposit;
use App\Models\InvestmentLog;
use App\Models\Notification;
use App\Models\TradeLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WithdrawLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            EmailSmsTemplateSeeder::class,
            SmsGatewaySeeder::class,
            PluginConfigurationSeeder::class,
            MenuSeeder::class,
            FrontendSeeder::class,
            PaymentGatewaySeeder::class,
            WithdrawMethodSeeder::class,
            TimeTableSeeder::class,
            InvestmentPlanSeeder::class,
            MatrixSeeder::class,
            LanguageSeeder::class,
            CronSeeder::class,
            StakingInvestmentSeeder::class,
            InvestmentUserRewardSeeder::class
        ]);

        Artisan::call('app:crypto-currency');
    }
}
