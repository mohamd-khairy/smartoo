<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'key' => $this->faker->unique()->word,
            // 'translations' => [
            //     ['lang' => 'en', 'val' => $this->faker->sentence],
            //     ['lang' => 'ar', 'val' => $this->faker->sentence]
            // ],

            'key' => 'hello',
            'translations' => [
                ['lang' => 'en', 'val' => 'hello'],
                ['lang' => 'ar', 'val' => 'مرحبا']
            ],
        ];
    }
}
