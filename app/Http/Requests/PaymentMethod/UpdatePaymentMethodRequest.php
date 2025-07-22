<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
        $paymentMethodId = $this->route('payment_method')->id;
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:payment_methods,slug,' . $paymentMethodId,
            'logo' => 'nullable|url',
            'base_url' => 'nullable|url',
            'app_key' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Name is required.',
            'name.string'         => 'Name must be a valid string.',
            'slug.required'       => 'Slug is required.',
            'slug.string'         => 'Slug must be a valid string.',
            'slug.unique'         => 'Slug has already been taken.',
            'logo.url'            => 'Logo must be a valid URL.',
            'base_url.url'        => 'Base URL must be a valid URL.',
            'app_key.string'      => 'App key must be a valid string.',
            'app_secret.string'   => 'App secret must be a valid string.',
            'username.string'     => 'Username must be a valid string.',
            'password.string'     => 'Password must be a valid string.',
        ];
    }
}
