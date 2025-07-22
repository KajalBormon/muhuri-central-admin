<?php

namespace App\Http\Requests\API\Subscritpion;

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
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'price' => 'required|integer',
            'discount_amount' => 'required|integer',
            'final_price' => 'required|integer',
            'is_trial_taken' => 'required',
            'trial_start_date' => 'nullable|date',
            'trial_end_date' => 'nullable|date',
            'note' => 'nullable',
            'is_active' => 'required',
            'workspace' => 'required|exists:companies,workspace'
        ];
    }

    public function messages()
    {
        return [
            'subscription_plan_id.required' => 'Subscription plan is required.',
            'subscription_plan_id.exists' => 'Selected subscription plan does not exist.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',          
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',           
            'price.required' => 'Price is required.',
            'price.integer' => 'Price must be an integer.',          
            'discount_amount.required' => 'Discount amount is required.',
            'discount_amount.integer' => 'Discount amount must be an integer.',          
            'final_price.required' => 'Final price is required.',
            'final_price.integer' => 'Final price must be an integer.',           
            'is_trial_taken.required' => 'Trial status is required.',          
            'trial_start_date.date' => 'Trial start date must be a valid date.',          
            'trial_end_date.date' => 'Trial end date must be a valid date.',         
            'is_active.required' => 'Active status is required.',
            'workspace.required' => 'Workspace is required.',
            'workspace.exists' => 'Selected workspace does not exist.',
        ];
    }
}
