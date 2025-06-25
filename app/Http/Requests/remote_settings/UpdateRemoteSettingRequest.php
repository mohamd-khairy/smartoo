<?php

namespace App\Http\Requests\remote_settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRemoteSettingRequest extends FormRequest
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
            // 'type' is the type of remote settings, it could be JSON, XML, etc.
            'type' => 'required|string|in:json,xml,yaml', // Example: 'json', 'xml', 'yaml'

            // 'value' contains the actual settings, it should be required and should be a valid JSON string (if type is JSON)
            'value' => 'required',  // You might want to add custom validation based on type (e.g., JSON validation if type is 'json')
        ];
    }
}
