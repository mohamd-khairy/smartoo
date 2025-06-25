<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,  // Name of the plan (e.g., Basic, Premium)
            'description' => $this->faker->sentence,  // Description of the plan
            'price' => $this->faker->randomFloat(2, 10, 100),  // Price of the plan (e.g., 19.99)
            'duration_days' => $this->faker->randomElement([30, 60, 90]),
            'currency' => 'USD',  // Currency of the plan (e.g., USD)
            'status' => $this->faker->randomElement(['active', 'inactive']),  // Status of the plan (e.g., active
        ];
    }
}
