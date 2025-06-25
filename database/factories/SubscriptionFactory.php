<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::first()->id,  // Create a user for the subscription (will use UserFactory)
            'plan_id' => Plan::first()->id,  // Create a plan for the subscription (will use PlanFactory)
            'start_date' => $this->faker->date(),  // Random start date for the subscription
            'end_date' => $this->faker->date(),  // Random end date for the subscription
            'status' => $this->faker->randomElement(['active', 'inactive', 'expired']),  // Subscription status
        ];
    }
}
