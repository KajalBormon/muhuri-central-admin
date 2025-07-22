<?php

namespace App\Http\Requests\Permission;

use App\Constants\Constants;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('permissions')->where(function ($query) {
                    return $query->where('guard_name', $this->guard_name);
                }),
            ],
            'group_name' => 'required',
            'display_name' => 'required'
        ];
    }

    /**
     * Validation messages
     */
    public function messages():array
    {
        return [
            'name.required' => __('validation.custom.permission.name.required'),
            'name.unique' => __('validation.custom.permission.name.unique'),
            'guard_name.required' => __('validation.custom.permission.guard_name.required'),
            'guard_name.in' => __('validation.custom.permission.guard_name.in'),
            'group_name.required' => __('validation.custom.permission.group_name.required'),
            'display_name.required' => __('validation.custom.permission.display_name.required')
        ];
    }
}
