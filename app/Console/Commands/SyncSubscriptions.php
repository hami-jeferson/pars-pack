<?php

namespace App\Console\Commands;

use App\Jobs\CheckSubscribeStatusJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\App;
use App\Services\MockGooglePlayService;
use App\Services\MockAppleStoreService;
use Illuminate\Support\Facades\Log;

class SyncSubscriptions extends Command
{
    protected $signature = 'app:sync-subscriptions';
    protected $description = 'Synchronize subscription status for apps';

    public function __construct()
    {
        parent::__construct();

        // Register subscription services for each platform.
        $this->subscriptionServices = [
            'android' => app(MockGooglePlayService::class),
            'iOS' => app(MockAppleStoreService::class),
        ];
    }

    public function handle()
    {
        $apps = App::with('platform')->get();
        $date = now()->toDateString();
        foreach ($apps as $app) {

            $platformName = $app->platform->name;
            if (array_key_exists($platformName, $this->subscriptionServices)) {
                $subscriptionService = $this->subscriptionServices[$platformName];
                // reset expired count
                $this->resetExpiredCount($app);

                Log::info('start sync subscription status for app '.$platformName);
                // loop through subcriptions
                $this->syncSubscriptionsForApp($app, $subscriptionService, $date);
            }

        }

    }

    protected function resetExpiredCount(App $app)
    {
        $app->expired_subscriptions_count = 0;
        $app->save();
    }

    protected function syncSubscriptionsForApp($app, $service, $date)
    {
        foreach ($app->subscriptions as $subscription) {
            CheckSubscribeStatusJob::dispatch($service, $app, $subscription, $date);
        }
    }

}
