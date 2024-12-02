<?php

namespace App\Console\Commands;

use App\Enums\Trade\TradeOutcome;
use App\Enums\Trade\TradeStatus;
use App\Models\TradeLog;
use App\Services\Trade\ActivityLogService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class TradeOutcomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trade-outcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle(ActivityLogService $activityLogService): void
    {
        $tradeLogs = TradeLog::where('outcome', TradeOutcome::INITIATED->value)
            ->where('status',TradeStatus::RUNNING->value)
            ->where('arrival_time', '<', Carbon::now())
            ->get();


        foreach ($tradeLogs as $tradeLog){
            $activityLogService->result($tradeLog);
        }

    }
}
