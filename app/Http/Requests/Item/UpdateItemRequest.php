<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
        $itemId = $this->route('item')->id;
        return [
            'type' => 'required|string',
            'category_id' => 'nullable|exists:company_categories,id',
            'name' => 'required|string',
            'parent_id' => 'nullable',
            'slug' => 'required|string|max:255|unique:items,slug,'. $itemId,
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Item type is required.',
            'type.string' => 'Item type must be a valid string.',
            'category_id.exists' => 'The selected category does not exist.',
            'name.required' => 'Item name is required.',
            'name.string' => 'Item name must be a valid string.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'Slug must be unique.',
            'slug.string' => 'Slug must be a valid string.',
            'slug.max' => 'Slug may not be greater than 255 characters.',
            'description.string' => 'Description must be a valid string.',
        ];
    }
}
