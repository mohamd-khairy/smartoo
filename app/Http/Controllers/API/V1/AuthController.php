<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\MeRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\UpdateProfileRequest;
use App\Http\Requests\auth\VerifyRequest;
use App\Models\Subscription;

class AuthController extends Controller
{
    /**
     * auth register user
     * @param \App\Http\Requests\auth\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function register(RegisterRequest $request)
    {
        // $user = User::firstOrCreate(
        //     $request->only('device_type', 'uuid'),
        //     $request->validated()
        // );

        $user = User::where([
            'device_type' => $request->device_type,
            'uuid' => $request->uuid,
        ])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $user = User::create($request->validated());
        }

        if ($user && Hash::check($request->password, $user->password)) {
            return login_response($user, __('general.auth.login'), 200);
        }

        return api_response(null, __('general.auth.login_failed'), 401);
    }

    /**
     * auth login user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(MeRequest $request)
    {
        $user = $request->user();

        if (Hash::check($request->password, $user->password)) {
            return login_response($user, __('general.auth.login'), 200);
        }
        return api_response(null, __('general.auth.login_failed'), 401);
    }

    /**
     * auth update user
     * @param \App\Http\Requests\auth\UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $user = User::find($user->id);
        $user->update($request->validated());
        return api_response($user->refresh(), __('general.auth.profile_updated'), 200);
    }

    /**
     * auth Logout
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return api_response(null, __('general.auth.logout'), 200);
    }

    /**
     * auth refresh token
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete(); // Revoke all tokens
        return login_response($user, __('general.auth.token_refreshed'), 200);
    }
}
