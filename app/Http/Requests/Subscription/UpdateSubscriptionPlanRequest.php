<?php

namespace App\Http\Requests\Subscription;

use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subscriptionPlanId = $this->route('subscription_plan')->id;
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:subscription_plans,slug,' . $subscriptionPlanId,
            'category_id' => 'nullable|exists:company_categories,id',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'plan_type' => 'required|string|in:'.implode(',', [Constants::MONTHLY, Constants::YEARLY]),
            'duration' => 'required|integer|min:1',
            'duration_unit' => 'required|string|in:'.Constants::MONTHS,
            'trial_duration' => 'required|integer|min:0',
            'trial_duration_unit' => 'required|string|in:'.Constants::MONTHS,
            'discount_amount' => 'nullable|integer|min:0',
            'note' => 'nullable|string',
        ];
    }

    function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'slug.required' => 'Slug is required',
            'slug.string' => 'Slug must be a string',
            'slug.unique' => 'Slug must be unique',
            'category_id.exists' => 'The selected category does not exist.',
            'description.string' => 'Description must be a string',
            'price.required' => 'Price is required',
            'price.integer' => 'Price must be an integer',
            'price.min' => 'Price must be at least 0',
            'plan_type.required' => 'Plan type is required',
            'plan_type.string' => 'Plan type must be a string',
            'plan_type.in' => 'Plan type must be either monthly or yearly',
            'duration.required' => 'Duration is required',
            'duration.integer' => 'Duration must be an integer',
            'duration.min' => 'Duration must be at least 1',
            'duration_unit.required' => 'Duration unit is required',
            'duration_unit.string' => 'Duration unit must be a string',
            'duration_unit.in' => 'Duration unit must be one of: months',
            'trial_duration.required' => 'Trial duration is required',
            'trial_duration.integer' => 'Trial duration must be an integer',
            'trial_duration.min' => 'Trial duration must be at least 0',
            'trial_duration_unit.string' => 'Trial duration unit must be a string',
            'trial_duration_unit.required' => 'Trial duration unit is required',
            'trial_duration_unit.in' => 'Trial duration unit must be one of: months',
            'discount_amount.integer' => 'Discount amount must be an integer',
            'discount_amount.min' => 'Discount amount must be at least 0',
            'note.string' => 'Note must be a string'
        ];
    }
}
