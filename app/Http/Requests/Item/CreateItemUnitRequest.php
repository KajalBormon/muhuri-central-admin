<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemUnitRequest extends FormRequest
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
            'name' => 'required|string',
            'value' => 'required|numeric',
            'display_name' => 'required|string',
            'form_display_name' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name type is required.',
            'name.string' => 'Name must be a valid string.',
            'value.required' => 'Value name is required.',
            'value.numeric' => 'Value must be a valid number.',
            'display_name.required' => 'Display name is required.',
            'display_name.string' => 'Display name must be string.',
            'form_display_name.required' => 'Form Display name is required.',
            'form_display_name.string' => 'Form Display name must be string.',
        ];
    }
}
