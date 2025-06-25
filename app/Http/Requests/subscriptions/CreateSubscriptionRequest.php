<?php

namespace App\Http\Requests\subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
            // 'user_id' should exist in the 'users' table (assuming subscriptions are linked to users)
            'user_id' => 'required|exists:users,id', // Ensure user exists

            // 'plan_id' should exist in the 'plans' table (assuming subscriptions are linked to plans)
            'plan_id' => 'required|exists:plans,id', // Ensure the selected plan exists

            // 'start_date' is required and should be a valid date
            'start_date' => 'required|date|before:end_date', // Ensure start date is before end date

            // 'end_date' is required and should be a valid date
            'end_date' => 'required|date|after:start_date', // Ensure end date is after start date

            // 'status' is required and must be one of the predefined values ('active', 'inactive', 'expired')
            'status' => 'required|in:active,inactive,expired',

        ];
    }
}
