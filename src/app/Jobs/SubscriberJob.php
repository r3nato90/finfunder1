<?php

namespace App\Jobs;

use App\Mail\GlobalMail;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $subscriber)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscriber = $this->subscriber;

        Mail::to($subscriber['email'])->send(new GlobalMail($subscriber['subject'],$subscriber['content'],));
    }
}
