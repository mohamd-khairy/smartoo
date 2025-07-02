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
            'uuid' => 'required',
            'device_type' => 'required|string',
            'country_code' => 'nullable|string',
            'locale' => 'nullable|string',
            'app_version' => 'nullable|string',
            'oc' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'client_id' => 'nullable|string',
        ];
    }
}
