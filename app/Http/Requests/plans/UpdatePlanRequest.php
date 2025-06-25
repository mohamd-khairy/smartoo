<?php

namespace App\Http\Requests\plans;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'name' => 'nullable|string|max:255|unique:plans,name,' . $this->id, // Name is optional for update but should be unique
            'description' => 'nullable|string|max:500', // Description is optional
            'price' => 'nullable|numeric|min:0', // Price is optional but should be numeric and at least 0
            'currency' => 'nullable|string|in:USD,EUR,GBP', // Currency is optional, must be one of the predefined values
            'duration_days' => 'nullable|integer|min:1', // Duration is optional, must be at least 1 day
            'status' => 'nullable|in:active,inactive', // Status is optional but must be either active or inactive
        ];
    }
}
