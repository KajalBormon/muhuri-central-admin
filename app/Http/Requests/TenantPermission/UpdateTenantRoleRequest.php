<?php

namespace App\Http\Requests\TenantPermission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantRoleRequest extends FormRequest
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
        $tenantRoleId = $this->route('tenant_role')->id;
        return [
            'name' => 'required|unique:tenant_roles,name,' .$tenantRoleId,
            'tenant_permission_ids' => 'nullable|array'
        ];
    }

    /**
     * Validation Messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The tenant role name is required.',
            'name.unique' => 'This tenant role name already exists.',
            'tenant_permission_ids.array' => 'The tenant permissions must be an array of IDs.'
        ];
    }
}
