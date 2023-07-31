<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\App;
use App\Models\Platform;
use App\Models\Subscription;
use App\Models\ExpiredSubscription;

class MigrationsAndModelsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test database migrations and model relationships.
     *
     * @return void
     */
    public function testMigrationsAndModels()
    {
        // Run the database migrations
        $this->artisan('migrate');

        // Assert that the 'platforms' table exists
        $this->assertTrue(\Schema::hasTable('platforms'));

        // Assert that the 'apps' table exists
        $this->assertTrue(\Schema::hasTable('apps'));

        // Assert that the 'subscriptions' table exists
        $this->assertTrue(\Schema::hasTable('subscriptions'));

        // Assert that the 'expired_subscriptions' table exists
        $this->assertTrue(\Schema::hasTable('expired_subscriptions'));

        // Create test data using factories and check model relationships
        $platform = Platform::factory()->create();
        $app = App::factory()->create(['platform_id' => $platform->id]);
        $subscription = Subscription::factory()->create(['app_id' => $app->id]);
        $expiredSubscription = ExpiredSubscription::factory()->create();

        $this->assertInstanceOf(Platform::class, $app->platform);
        $this->assertInstanceOf(App::class, $subscription->app);
        $this->assertInstanceOf(ExpiredSubscription::class, $expiredSubscription);

    }
}
