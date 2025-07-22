<?php

namespace App\Http\Requests\JobPosition;

use App\Models\JobPosition;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJobPositionRequest extends FormRequest
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
        $jobPositionId = $this->route('job_position')->id;
        return [
            'name' => 'required|unique:job_positions,name,'.$jobPositionId
        ];
    }

    /**
     * Validation Messages
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.custom.jobPosition.name.required'),
            'name.unique' => __('validation.custom.jobPosition.name.unique')
        ];
    }
}
