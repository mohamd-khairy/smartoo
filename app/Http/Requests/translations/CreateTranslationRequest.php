<?php

namespace App\Http\Requests\translations;

use Illuminate\Foundation\Http\FormRequest;

class CreateTranslationRequest extends FormRequest
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
        // Get the translation ID for the update request (if this is for an update operation)

        return [
            // 'key' is the translation key (e.g., 'greeting', 'welcome_message')
            'key' => 'required|string|max:255|unique:translations,key,code,' . $this->code, // Ensure the key is unique for the same language code

            // 'value' is the actual translation value (e.g., 'Hello', 'Bienvenue')
            'translations' => 'required|array|max:1000', // The translation value is required and can be a maximum of 1000 characters
        ];
    }
}
