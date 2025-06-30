<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Requests\auth\UpdateProfileRequest;
use App\Http\Requests\auth\VerifyRequest;
use App\Models\Subscription;

class AuthController extends Controller
{
    /**
     * auth register a new user (either anonymous or with full details)
     * @param \App\Http\Requests\auth\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // Create an anonymous user with just a phone number and device info
        $user = User::firstOrCreate([
            'device_type' => $data['device_type'],
            'uuid' => $data['uuid'],
        ], [
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => $data['password'] ?? null,
            'phone' => $data['phone'] ?? null,
            'device_type' => $data['device_type'],
            'phone_verification_code' => rand(100000, 999999),
            'mac_address' => $data['mac_address'] ?? null,
            'timezone' => $data['timezone'] ?? 'UTC',
            'ip_address' => $request->ip(),
            'device_token' => $request->header('Device-Token') ?? $data['device_token'] ?? null,
            'country_code' => $data['country_code'] ?? null,
            'role' => 'user',
            'locale' => 'en',
            'status' => 'pending',
            'last_login_at' => null,
            'gender' => $data['gender'] ?? null,
            'contact_permission' => $data['contact_permission'] ?? false,
            'notification_permission' => $data['notification_permission'] ?? false,
            'tracking_permission' => $data['tracking_permission'] ?? false,
            'subscription_id' => $data['subscription_id'] ?? null,
        ]);

        // Cache the verification code for the user
        // Cache::put("verification_code_{$data['phone']}", $user->phone_verification_code, now()->addMinutes(5));

        // You can use a service like Twilio to send the verification code here
        // Twilio::sendSms($data['phone'], "Your verification code is: {$user->phone_verification_code}");

        if ($user) {
            $user->touch('last_login_at');
            return login_response($user, __('general.auth.phone_verified'), 200);
            // return api_response($user, __('general.auth.phone_verification_code_sent'), 201);
        }

        return api_response(null, __('general.auth.invalid_verification_code'), 401);
    }

    /**
     * auth login user
     * @param \App\Http\Requests\auth\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('phone', $data['phone'])->first();

        if (!$user) {
            return api_response(null, __('general.auth.not_found'), 404);
        }

        $verificationCode = rand(100000, 999999);
        Cache::put("verification_code_{$data['phone']}", $verificationCode, now()->addMinutes(5));

        // Update user phone verification code in case they try again
        $user->update([
            'phone_verification_code' => $verificationCode,
            'status' => 'pending',
        ]);

        // Send SMS with the new verification code (using Twilio or similar)
        // Twilio::sendSms($data['phone'], "Your verification code is: {$verificationCode}");

        return api_response($user, __('general.auth.phone_verification_code_sent'), 200);
    }

    /**
     * auth resend verification code
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function resendVerificationCode(LoginRequest $request)
    {
        // Find the user by phone number
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return api_response(null, 'User not found', 404);
        }

        // Generate a new phone verification code
        $verificationCode = rand(100000, 999999); // You can use a more secure random generator if needed

        // Store the verification code in the database and cache it for quick access (optional)
        $user->phone_verification_code = $verificationCode;
        $user->save();

        // Optionally, cache the verification code for a period (e.g., 5 minutes)
        Cache::put("verification_code_{$user->phone}", $verificationCode, now()->addMinutes(5));

        // Send the verification code to the user's phone (using a service like Twilio or Nexmo)
        // For demonstration, this can be done through any SMS service
        // Twilio::sendSms($user->phone, "Your verification code is: {$verificationCode}");

        // Return success response
        return api_response(true, 'Verification code sent successfully.', 200);
    }

    /**
     * auth verify phone number
     * @param \App\Http\Requests\auth\VerifyRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function verifyPhoneNumber(VerifyRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        // Verify the code
        if (Cache::get("verification_code_{$user->phone}") == $request->verification_code) {
            // Mark the user as verified
            $user->update([
                'phone_verified_at' => now(),
                'status' => 'active',
                'last_login_at' => now(),
                'phone_verification_code' => null, // Clear the verification code
            ]);

            return login_response($user, __('general.auth.phone_verified'), 200);
        }

        return api_response(null, __('general.auth.invalid_verification_code'), 401);
    }

    /**
     * auth Get the authenticated user's profile
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile(Request $request)
    {
        return api_response($request->user(), __('general.auth.profile_retrieved'), 200);
    }

    /**
     * auth update profile
     * @param \App\Http\Requests\auth\UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();

        // Update user profile with validated data
        $user->update($request->validated());

        // Check if a new subscription ID is provided in the request
        if ($request->has('subscription_id')) {
            // Check if the provided subscription_id exists in the subscriptions table
            $subscription = Subscription::find($request->subscription_id);

            if ($subscription) {
                // Update the user's subscription_id with the new plan
                $user->subscription()->associate($subscription);
                $user->save();
            }
        }

        return api_response($user, __('general.auth.profile_updated'), 200);
    }

    /**
     * auth Logout the user and revoke their token
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
