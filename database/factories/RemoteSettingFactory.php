<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RemoteSetting>
 */
class RemoteSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_code' => 'default',
            'type' => 'json', // Random type
            'value' => json_encode([
                "app_config" => [
                    "version" => "1.2.3",
                    "features" => [
                        "dark_mode" => [
                            "enabled" => true,
                            "description" => "Enable dark mode for the app UI."
                        ],
                        "new_onboarding_flow" => [
                            "enabled" => false,
                            "description" => "New onboarding flow for first-time users."
                        ],
                        "live_chat_support" => [
                            "enabled" => true,
                            "available_hours" => "9am - 6pm",
                            "support_email" => "support@company.com"
                        ]
                    ],
                    "ui_settings" => [
                        "primary_color" => "#4CAF50",
                        "accent_color" => "#FF5722",
                        "font_size" => "14px",
                        "show_tutorial_popup" => true
                    ],
                    "content" => [
                        "home_page_banner" => [
                            "enabled" => true,
                            "banner_text" => "Welcome to our new features!",
                            "image_url" => "https://example.com/banner.jpg"
                        ],
                        "promo_code" => [
                            "enabled" => true,
                            "code" => "DISCOUNT20",
                            "valid_until" => "2025-12-31"
                        ]
                    ],
                    "api_endpoints" => [
                        "user_profile" => "https://api.example.com/v1/user/profile",
                        "user_data_fetch" => "https://api.example.com/v1/user/data",
                        "contact_support" => "https://api.example.com/v1/support/contact"
                    ]
                ],
                "user_preferences" => [
                    "language" => "en",
                    "notifications_enabled" => true,
                    "push_notifications" => [
                        "enabled" => true,
                        "types" => [
                            "new_message",
                            "promotion",
                            "app_update"
                        ]
                    ]
                ]
            ]) // Encoded JSON string
        ];
    }
}
