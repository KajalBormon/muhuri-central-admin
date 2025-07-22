<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionPlanFeatureRequest extends FormRequest
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
            'title' => 'required|string|unique:subscription_plan_features'
        ];
    }

    function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.unique' => 'Title already exists'
        ];
    }
}
