<?php

use Illuminate\Database\Seeder;
use App\Models\App;
use App\Models\Platform;
use App\Models\Subscription;
use Faker\Generator;

class DatabaseSeeder extends Seeder
{
    protected $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function run()
    {
        // Check if 'android' platform exists, otherwise create it.
        $androidPlatform = Platform::where('name', 'android')->first();
        if (!$androidPlatform) {
            $androidPlatform = Platform::factory()->create(['name' => 'android']);
        }

        // Check if 'iOS' platform exists, otherwise create it.
        $iOSPlatform = Platform::where('name', 'iOS')->first();
        if (!$iOSPlatform) {
            $iOSPlatform = Platform::factory()->create(['name' => 'iOS']);
        }

        // Create 10 apps and randomly assign different platforms to each app.
        App::factory()->count(10)->create()->each(function ($app) use ($androidPlatform, $iOSPlatform) {
            // Randomly select a platform for each app.
            $platformId = $this->faker->randomElement([$androidPlatform->id, $iOSPlatform->id]);
            $app->update(['platform_id' => $platformId]);

            // For each app, create subscriptions.
            $app->subscriptions()->saveMany(
                Subscription::factory()->count(5)->make(['app_id' => $app->id])
            );
        });
    }
}

