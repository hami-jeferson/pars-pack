<?php

namespace App\Events;

use App\Contracts\SubscriptionServiceInterface;
use App\Models\App;
use App\Models\Subscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionStatusChecked
{
    use Dispatchable, SerializesModels;

    public $service;
    public $app;
    public $subscription;
    public $date;

    public function __construct(SubscriptionServiceInterface $service, App $app, Subscription $subscription, string $date)
    {
        $this->service = $service;
        $this->app = $app;
        $this->subscription = $subscription;
        $this->date = $date;
    }
}
