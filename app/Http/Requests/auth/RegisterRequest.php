<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|unique:users,phone',
            'device_type' => 'required|string',
            'mac_address' => 'nullable|string',
            'timezone' => 'nullable|string',
            'country_code' => 'nullable|string',
            'locale' => 'nullable|string',
            'gender' => 'nullable|string',
            'contact_permission' => 'nullable|boolean',
            'notification_permission' => 'nullable|boolean',
            'tracking_permission' => 'nullable|boolean',
            'device_token' => 'nullable|string',
            'subscription_id' => 'nullable|string|exists:subscriptions,id'
        ];
    }
}
