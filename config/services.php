<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'apple' => [ // Production
        'env_type' => env('APPlE_MODE', 'Sandbox'),
        'url' => env('APPlE_MODE', 'Sandbox')
            ? 'https://api.storekit-sandbox.itunes.apple.com'
            : 'https://api.storekit.itunes.apple.com',
        'sandbox_url' => 'https://api.storekit-sandbox.itunes.apple.com',
        'production_url' => 'https://api.storekit.itunes.apple.com',
        'issuer_id' => env('APPLE_ISSUER_ID', ''),
        'team_id' => env('APPLE_TEAM_ID', ''),
        'key_id' => env('APPLE_KEY_ID', ''),
        'client_id' => env('APPLE_CLIENT_ID', ''),
        'private_key_path' => env('APPLE_PRIVATE_KEY_PATH', ''),
        'shared_secret' => env('APPLE_SHARED_SECRET', ''),
    ],

];
