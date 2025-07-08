<?php

namespace App\Http\Requests\subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
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
            // 'plan_id' is required and should exist in the 'plans' table
            'product_id' => 'required|string', // Ensure the selected plan exists

            // 'start_date' is nullable, but if provided, it should be a valid date and must be before 'end_date'
            'expires_at' => 'nullable|date|before:end_date', // Make it nullable but check it if present

            // 'end_date' is nullable, but if provided, it should be a valid date and must be after 'start_date'
            'is_renewal' => 'nullable|boolean', // Make it nullable but check it if present

            // 'status' is nullable, but if provided, it must be one of 'active', 'inactive', 'expired'
            'status' => 'nullable|in:active,inactive,expired',
        ];
    }
}
