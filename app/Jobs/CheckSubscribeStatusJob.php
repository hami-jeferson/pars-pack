<?php

namespace App\Jobs;

use App\Contracts\SubscriptionServiceInterface;
use App\Models\App;
use App\Models\ExpiredSubscription;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckSubscribeStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $service;
    protected $app;
    protected $subscription;
    protected $date;
    protected $isRetry;
    /**
     * Create a new job instance.
     */
    public function __construct(SubscriptionServiceInterface $service, App $app, Subscription $subscription, string $date, int $isRetry = 0)
    {
        $this->service = $service;
        $this->app = $app;
        $this->subscription = $subscription;
        $this->date = $date;
        $this->isRetry = $isRetry;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->isRetry){
            Log::info("Retrying App ID: {$this->app->id}, Subscription: {$this->subscription->email} now...");
        }else{
            Log::info("Trying App ID: {$this->app->id}, Subscription: {$this->subscription->email} now...");
        }

        $response = $this->service->checkSubscriptionStatus($this->app->uuid, $this->subscription);
        if($response['status'] == 'error'){ //
            // Schedule a retry based on the platform and response status code.
            $this->scheduleRetry();
        }else{

            // notif admin on change status from ative to expired
            Log::info('status is '.$this->subscription->status);
            if($response['status'] == 'expired'){
                if($this->subscription->status == 'active'){
                    $this->sendEmailNotification();
                }
            }

            // update status of subscription
            $this->updateSubscription($response['status']);

        }
    }

    protected function saveRecord(string $response){
        if($response == 'expired') {
            $record = ExpiredSubscription::where('sync_date', $this->date)->first();
            if ($record) {
                $record->increment('expired_count', 1);
            } else {
                ExpiredSubscription::create(['expired_count' => 1, 'sync_date' => $this->date]);
            }
        }
    }

    protected function updateSubscription(string $response)
    {
        $this->saveRecord($response);

        $this->subscription->previous_status = $this->subscription->status;
        $this->subscription->status = $response;
        $this->subscription->save();
    }

    protected function sendEmailNotification()
    {
        ChangeSubscriptionStatusJob::dispatch($this->app->name, $this->subscription->email);
    }

    protected function scheduleRetry()
    {
        Log::info("Scheduling a retry for App ID: {$this->app->id}, Subscription: {$this->subscription->email} after {$this->service->getDelay()} seconds...");

        $command = new CheckSubscribeStatusJob($this->service, $this->app, $this->subscription, $this->date, 1);

        // Calculate the delay in seconds (assuming $delay contains the desired delay in seconds)
        $delayInSeconds = $this->service->getDelay();

        dispatch($command)->delay(now()->addSeconds($delayInSeconds));

    }
}
