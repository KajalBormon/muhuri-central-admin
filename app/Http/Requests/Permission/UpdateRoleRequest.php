<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('role')->id;
        return [
            'name' => 'required|unique:roles,name,' . $roleId,
            'permission_ids' => 'nullable|array'
        ];
    }

    /**
     * Validation Messages
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.custom.role.name.required'),
            'name.unique' => __('validation.custom.role.name.unique'),
            'permission_ids.array' => __('validation.custom.role.permission_ids.array')
        ];
    }
}
