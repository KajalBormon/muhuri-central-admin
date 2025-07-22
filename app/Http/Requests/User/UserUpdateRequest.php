<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user')->id;
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId,
            'roles' => 'nullable|array'
        ];
    }

     /**
     * Vlidation Messages
     */
    public function messages()
    {
        return [
            'name.required' => __('validation.custom.user.name.required'),
            'email.required' => __('validation.custom.user.email.required'),
            'email.email' => __('validation.custom.user.email.email'),
            'email.unique' => __('validation.custom.user.email.unique'),
            'password.required' => __('validation.custom.user.password.required'),
            'roles.array' => __('validation.custom.user.roles.array')
        ];
    }
}
