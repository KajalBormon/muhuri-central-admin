<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordRequest extends FormRequest
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
            'current_password' => 'required|current_password',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => __('validation.custom.user.current_password.required'),
            'current_password.current_password' => __('validation.custom.user.current_password.current_password'),
            'password.required' => __('validation.custom.user.password.required'),          'password_confirmation.required' => __('validation.custom.user.password_confirmation.required'),
            'password_confirmation.same' => __('validation.custom.user.password_confirmation.same')
        ];
    }
}
