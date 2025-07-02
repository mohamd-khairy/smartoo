<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'country_code' => 'nullable|string|size:2',

            // 'locale' => 'nullable|string|in:en,ar',
            // 'gender' => 'nullable|string|in:male,female',
            // 'device_token' => 'nullable|string',
            // 'subscription_id' => 'nullable|string',

            // 'email' => 'nullable|email|unique:users,email,' . $this->id,
            // 'password' => 'nullable|string|min:8',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'contact_permission' => 'nullable|boolean',
            // 'notification_permission' => 'nullable|boolean',
            // 'tracking_permission' => 'nullable|boolean',
        ];
    }
}
