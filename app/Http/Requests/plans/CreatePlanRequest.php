<?php

namespace App\Http\Requests\plans;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
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
            'name' => 'required|string|max:255', // Plan name (required, string, max 255 characters)
            'description' => 'nullable|string|max:500', // Plan description (optional, string, max 500 characters)
            'price' => 'required|numeric|min:0', // Price of the plan (required, numeric, must be positive)
            'currency' => 'required|string|in:USD,EUR,GBP', // Currency (required, string, specific set of currencies)
            'duration_days' => 'required|integer|min:1', // Duration of the plan in days (required, integer, at least 1 day)
            'status' => 'required|in:active,inactive', // Status of the plan (required, either active or inactive)
        ];
    }
}
