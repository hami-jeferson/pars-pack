<?php

namespace App\Contracts;

use App\Models\Subscription;

interface SubscriptionServiceInterface
{
    public function checkSubscriptionStatus(string $appUuid, Subscription $subscription): array;

    public function setDelay(int $delay): void;

    public function getDelay(): int;
}
