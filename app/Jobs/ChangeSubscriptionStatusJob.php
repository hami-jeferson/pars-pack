<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChangeSubscriptionStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appName, $subscriberEmail;
    /**
     * Create a new job instance.
     */
    public function __construct(string $appName, string $subscriberEmail)
    {
        $this->appName = $appName;
        $this->subscriberEmail = $subscriberEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("send email for {$this->appName}, {$this->subscriberEmail}");
        Mail::to(config('app.admin_email'))->send(new \App\Mail\SubscriptionStatusChanged($this->appName, $this->subscriberEmail));
    }
}
