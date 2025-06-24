<?php

use App\Models\RemoteSetting;
use App\Models\Translation;

if (!function_exists('login_response')) {
    /**
     * Generate a standardized API response for login.
     *
     * @param \App\Models\User|null $user The authenticated user
     * @param string $message The response message
     * @param int $statusCode The HTTP status code
     * @return \Illuminate\Http\JsonResponse
     */
    function login_response($user = null, $message = '', $statusCode = 200)
    {
        // If user is provided, prepare data for response
        $data = $user ? [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
            // Cache translations per user locale to optimize performance
            'translations' => cache()->remember("translations_{$user->locale}", now()->addHours(1), function () use ($user) {
                return Translation::where('locale', $user->locale)
                    ->pluck('value', 'key')
                    ->toArray();
            }),
            // Cache remote settings based on user's country code with a default fallback
            'remote_settings' => cache()->remember("remote_settings_{$user->country_code}", now()->addHours(1), function () use ($user) {
                return RemoteSetting::where('country_code', $user->country_code)
                    ->value('value') ?: []; // Cache the remote settings, fallback to empty array if not found
            }),
        ] : null;

        // Return the API response with success flag, message, and data
        return api_response($data, $message, $statusCode);
    }
}

if (!function_exists('api_response')) {
    /**
     * Generate a standardized API response.
     *
     * @param mixed $data The data to return in the response
     * @param string $message The response message
     * @param int $statusCode The HTTP status code
     * @param array $meta Additional metadata (e.g., pagination)
     * @return \Illuminate\Http\JsonResponse
     */
    function api_response($data = null, $message = '', $statusCode = 200)
    {
        return response()->json([
            'success' => $statusCode < 400,
            'message' => $message,
            'data' => $data ?? new \stdClass(),  // Return empty object if no data
        ], $statusCode);
    }
}
