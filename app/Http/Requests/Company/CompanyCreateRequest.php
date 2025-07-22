<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'name' => 'required|string',
            'name_bn' => 'required|string',
            'category_id' => 'required|exists:company_categories,id',
            'mobile_number' => 'required|unique:companies,mobile_number',
            'additional_mobile_number' => 'nullable|string|different:mobile_number',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|same:password',
            'workspace' => 'required|string|unique:companies,workspace',
            'division_id' => 'nullable|exists:location_divisions,id',
            'district_id' => 'nullable|exists:location_districts,id',
            'upazila_id' => 'nullable|exists:location_upazilas,id',
            'union_id' => 'nullable|exists:location_unions,id',
            'village' => 'nullable|string'
        ];
    }

    function messages()
    {
        return [
            'subscription_plan_id.required' => 'Subscription plan is required.',
            'subscription_plan_id.exists' => 'The selected subscription plan does not exist.',

            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',

            'name_bn.required' => 'Bangla name is required.',
            'name_bn.string' => 'Bangla name must be a string.',

            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'The selected category does not exist.',

            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.unique' => 'This mobile number is already in use.',

            'additional_mobile_number.string' => 'Additional mobile number must be a string.',
            'additional_mobile_number.different' => 'Additional mobile number cannot be the same as the primary mobile number.',

            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',

            'password_confirmation.required' => 'Password confirmation is required.',
            'password_confirmation.same' => 'The password confirmation does not match.',

            'workspace.required' => 'Workspace is required.',
            'workspace.string' => 'Workspace must be a string.',
            'workspace.unique' => 'This workspace is already in use.',

            'division_id.exists' => 'selected division does not exist.',

            'district_id.exists' => 'selected district does not exist.',

            'upazila_id.exists' => 'selected upazila does not exist.',

            'union_id.exists' => 'selected union does not exist.',

            'village.string' => 'village must be a string.'
        ];
    }
}
