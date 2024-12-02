<?php

namespace App\Console\Commands;

use App\Services\Investment\InvestmentService;
use Illuminate\Console\Command;

class InvestmentProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:investment-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Investment Process Here';

    /**
     * @param InvestmentService $investmentService
     * @return void
     */
    public function handle(InvestmentService $investmentService): void
    {
        $investmentService->cron();
        $this->info("Investment Job is being processed");
    }
}
