<?php

namespace App\Providers;

use App\Contracts\SubscriptionServiceFactoryInterface;
use App\Models\ExpiredSubscription;
use App\Models\Subscription;
use App\Observers\ExpiredSubscriptionObserver;
use App\Observers\SubscriptionObserver;
use App\Services\SubscriptionServiceFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Subscription::observe(SubscriptionObserver::class);
    }
}
