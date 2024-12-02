<?php

namespace App\Jobs\CoinbaseWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Shakurov\Coinbase\Models\CoinbaseWebhookCall;

class HandleCreatedCharge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected CoinbaseWebhookCall $webhookCall)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->webhookCall->payload;
    }
}
