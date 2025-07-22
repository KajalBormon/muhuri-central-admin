<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends FormRequest
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
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ];
    }

    /**
     * Validation messages
     */
    public function messages()
    {
        return [
            'role_id.required' => __('validation.custom.role.role_id.required'),
            'role_id.exists' => __('validation.custom.role.role_id.exists'),
            'permission_id.required' => __('validation.custom.role.permission_id.required'),
            'permission_id.exists' => __('validation.custom.role.permission_id.exists')
        ];
    }
}
