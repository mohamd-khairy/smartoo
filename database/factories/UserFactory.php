<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'country_code' => 'EG', // Generate a random country code
            'phone' => fake()->unique()->phoneNumber(), // Generate a unique phone number
            'phone_verification_code' => rand(100000, 999999), // Generate a random 6-digit verification code
            'phone_verified_at' => now(), // Default phone verification time is now
            'locale' => 'en', // Default language is English
            'status' => 'active', // Default status is 'active
            'role' => 'user', // Default role is 'user
            'image' => null, // 'https://via.placeholder.com/150', // Placeholder image URL
            'created_at' => now(),
            'updated_at' => now(),
            'last_login_at' => now(), // Default last login time is now
            'ip_address' => fake()->ipv4(), // Generate a random IP address
            'mac_address' => fake()->macAddress(), // Generate a random MAC address
            'device_type' => 'mobile', // Default device type is 'mobile
            'device_token' => Str::random(60), // Generate a random device token
            'timezone' => 'UTC', // Default timezone is 'UTC',
            'contact_permission' => false, // Default contact permission is false
            'notification_permission' => false, // Default notification permission is false
            'tracking_permission' => false, // Default tracking permission is false
            'subscription_id' => null, // Default subscription ID is null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
