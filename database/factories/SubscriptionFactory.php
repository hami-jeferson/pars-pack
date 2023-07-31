<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['active', 'expired', 'pending']),
            'f_name' => $this->faker->firstName(),
            'l_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            // app_id will be set later when creating subscriptions.
        ];
    }
}
