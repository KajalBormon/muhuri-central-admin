<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'workspace' => 'required',
            'allowed_domains' => 'nullable|array',
        ];
    }

    function messages()
    {
        return [
            'name.required' => trans('validation.name_required'),
            'email.required' => trans('validation.email_required'),
            'workspace.required' => trans('validation.workspace_required')
        ];
    }
}
