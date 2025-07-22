<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'roles' => 'nullable|array'
        ];
    }

    function messages()
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
