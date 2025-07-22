<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    /**
     * Validation messages
     */
    public function messages()
    {
        return [
            'user_id.required' => __('validation.custom.role.user_id.required'),
            'user_id.exists' => __('validation.custom.role.user_id.exists'),
            'role_id.required' => __('validation.custom.role.role_id.required'),
            'role_id.exists' => __('validation.custom.role.role_id.exists')
        ];
    }
}
