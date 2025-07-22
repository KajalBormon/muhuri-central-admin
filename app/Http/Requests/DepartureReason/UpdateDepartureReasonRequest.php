<?php

namespace App\Http\Requests\DepartureReason;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartureReasonRequest extends FormRequest
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
        $departureReasonId = $this->route('departure_reason')->id;
        return [
            'name' => 'required|unique:departure_reasons,name,' . $departureReasonId
        ];
    }

    /**
     * Validation Messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Departure reason name is required',
            'name.unique' => 'Departure reason should be unique'
        ];
    }
}
