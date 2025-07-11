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
        if ($user && $user->locale) {
            setEnv('APP_LOCALE', $user->locale);
            $user->touch('last_login_at');
        }

        Translation::whereNull('translations')->delete();
        $data = $user ? [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
            'translations' => Translation::whereNotNull('translations')->get()->mapWithKeys(function ($item) {
                $obj = new \stdClass();
                $obj->{$item->key} = $item->value;
                return [$item->key => $obj];
            }),
            'remote_settings' =>  json_decode(RemoteSetting::where('country_code', 'default' ?? $user->country_code)->value('value') ?: '[]')
        ] : null;

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
            'result' => $data ?? new \stdClass(),  // Return empty object if no data
        ], $statusCode);
    }
}

if (!function_exists('setEnv')) {
    /**
     * Update or create an environment variable in the .env file.
     *
     * @param string $key The environment variable key
     * @param string $value The environment variable value
     */
    function setEnv($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents(
                $path,
                preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    file_get_contents($path)
                )
            );
        }
    }
}
