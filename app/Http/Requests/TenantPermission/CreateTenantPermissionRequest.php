<?php

namespace App\Http\Requests\TenantPermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTenantPermissionRequest extends FormRequest
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
            'name' => 'required|unique:tenant_permissions,name',
            'group_name' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The tenant permission name is required.',
            'name.unique' => 'The tenant permission name must be unique for the selected guard.',
            'group_name.required' => 'The group name is required.'
        ];
    }
}
