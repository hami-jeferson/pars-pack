<?php

namespace App\Services;

use App\Contracts\SubscriptionServiceInterface;
use App\Models\Subscription;

class MockAppleStoreService implements SubscriptionServiceInterface
{
    protected $delay;

    public function __construct()
    {
        $this->setDelay(7200);
    }

    public function setDelay($delay):void
    {
        $this->delay = $delay;
    }

    public function getDelay():int
    {
        return $this->delay;
    }
    /**
     * @param int $appId
     * @return array
     */
    public function checkSubscriptionStatus(string $appUuid, Subscription $subscribe): array
    {
        // Simulate a non-200 response to trigger a retry.
        if (rand(1, 10) === 1) {
            return ['status'=>'error'];
        }

        // Simulate a successful response with 'expired' status.
        $randomStatus = ['active', 'pending', 'expired'][rand(0, 2)];
        return ['status' => $randomStatus];
    }
}
