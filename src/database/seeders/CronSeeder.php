<?php

namespace Database\Seeders;

use App\Enums\CronCode;
use App\Enums\Email\EmailSmsTemplateName;
use App\Models\Cron;
use App\Models\EmailSmsTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CronSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cron = [
            [
                'code' => CronCode::CRYPTO_CURRENCY->value,
                'name' => "Crypto-Currency",
                'ideal_time' => 'Daily',
            ],
            [
                'code' => CronCode::INVESTMENT_PROCESS->value,
                'name' => "Investment Process",
                'ideal_time' => 'Every Minute',
            ],
            [
                'code' => CronCode::TRADE_OUTCOME->value,
                'name' => "Trade Outcome",
                'ideal_time' => 'Every Minute',
            ],
            [
                'code' => CronCode::QUEUE_WORK->value,
                'name' => "Queue Work",
                'ideal_time' => 'Every Minute',
            ],

        ];

        Cron::truncate();
        collect($cron)->each(fn($value) => Cron::create($value));
    }
}
