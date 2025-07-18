<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'nullable|email|unique:users,email,' . $this->id,
            'phone' => 'nullable|string|unique:users,phone,' . $this->id,
            'password' => 'nullable|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable|string|in:admin,supervisor,employee,user',
            'device_type' => 'nullable|string',
            'idfa_token' => 'nullable|string',
            'device_token' => 'nullable|string',
            'age_id' => 'nullable|integer',
            
            'mac_address' => 'nullable|string',
            'timezone' => 'nullable|string',
            'locale' => 'nullable|string|in:en,ar',
            'country_code' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female',
            'contact_permission' => 'nullable|boolean',
            'notification_permission' => 'nullable|boolean',
            'tracking_permission' => 'nullable|boolean',
            'subscription_id' => 'nullable|string|exists:subscriptions,id'
        ];
    }
}
