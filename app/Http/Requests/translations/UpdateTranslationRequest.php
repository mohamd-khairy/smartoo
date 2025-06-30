<?php

namespace App\Http\Requests\translations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
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
        // Get the translation ID for the update request (from the route)
        $translationId = $this->route('id'); // Assuming translation ID is passed as 'translation' in route

        return [
            // 'key' is the translation key (e.g., 'greeting', 'welcome_message')
            // Ensure the 'key' is unique, but skip the current translation being updated
            'key' => 'required|string|max:255|unique:translations,key,id,code,' . $this->code, // Ensure the key is unique for the same language code

            // 'value' is the actual translation value (e.g., 'Hello', 'Bienvenue')
            'translations' => 'nullable|array|max:1000', // The translation value is optional for an update, but should be a string if provided
        ];
    }
}
