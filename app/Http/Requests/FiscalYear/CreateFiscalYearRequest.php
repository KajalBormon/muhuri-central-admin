<?php

namespace App\Http\Requests\FiscalYear;

use Illuminate\Foundation\Http\FormRequest;

class CreateFiscalYearRequest extends FormRequest
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
            'fiscal_year' => 'required|integer|unique:fiscal_years,fiscal_year',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'fiscal_year.required' => 'Fiscal year is required.',
            'fiscal_year.integer'  => 'Fiscal year must be an integer.',
            'fiscal_year.unique'   => 'Fiscal year already exists.',
            'start_date.required'  => 'Start date is required.',
            'start_date.date'      => 'Start date must be a valid date.',
            'start_date.before'    => 'Start date must be before the end date.',
            'end_date.required'    => 'End date is required.',
            'end_date.date'        => 'End date must be a valid date.',
            'end_date.after'       => 'End date must be after the start date.',
            'note.string'          => 'Note must be a string.',
        ];
    }
}
