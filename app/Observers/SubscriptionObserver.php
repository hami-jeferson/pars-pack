<?php

namespace App\Observers;

use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class SubscriptionObserver
{
    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        if($subscription->status == 'expired'){
            $subscription->app->expired_subscriptions_count += 1;
            $subscription->app->save();
        }
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }
}
