<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|unique:users,phone',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|string|in:admin,supervisor,employee,user',
            'device_type' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'timezone' => 'nullable|string',
            'device_token' => 'nullable|string',
            'locale' => 'nullable|string|in:en,ar',
            'country_code' => 'nullable|string',
            'gender' => 'nullable|string',
            'contact_permission' => 'nullable|boolean',
            'notification_permission' => 'nullable|boolean',
            'tracking_permission' => 'nullable|boolean',
            'subscription_id' => 'nullable|string'
        ];
    }
}
