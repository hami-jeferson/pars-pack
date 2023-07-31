<?php

use Tests\TestCase;
use App\Services\MockAppleStoreService;
use App\Services\MockGooglePlayService;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\WithFaker;

class ServicesTest extends TestCase
{
    use WithFaker;
    /**
     * Test MockAppleStoreService.
     *
     * @return void
     */
    public function testMockAppleStoreService()
    {
        $service = new MockAppleStoreService();
        $appUuid = $this->faker->uuid();
        $subscription = Subscription::factory()->make();

        $response = $service->checkSubscriptionStatus($appUuid, $subscription);

        // Assert that the response contains a 'status' key
        $this->assertArrayHasKey('status', $response);
    }

    /**
     * Test MockGooglePlayService.
     *
     * @return void
     */
    public function testMockGooglePlayService()
    {
        $service = new MockGooglePlayService();
        $appUuid = $this->faker->uuid();
        $subscription = Subscription::factory()->make();

        $response = $service->checkSubscriptionStatus($appUuid, $subscription);

        // Assert that the response contains a 'status' key
        $this->assertArrayHasKey('status', $response);
    }
}
