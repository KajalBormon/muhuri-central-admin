<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserPasswordUpdateRequest extends FormRequest
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
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
    }


    /**
     * Validation Messages
     */
    function messages()
    {
        return [
            'password.required' => __('validation.custom.user.password.required'),
            'password_confirmation.required' => __('validation.custom.user.password_confirmation.required'),
            'password_confirmation.same' => __('validation.custom.user.password_confirmation.same')
        ];
    }
}
