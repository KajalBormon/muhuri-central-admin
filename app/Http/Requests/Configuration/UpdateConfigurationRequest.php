<?php

namespace App\Http\Requests\Configuration;

use App\Models\Country;
use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigurationRequest extends FormRequest
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
            'name' => 'nullable|string',
            'organization_number' => 'nullable|numeric',
            'country_id' => [
                function ($attribute, $value, $fail) {
                    $this->validateCountry($attribute, $value, $fail);
                },
            ],
            'date_format' => 'nullable|string|in:'.implode(',', [Constants::Y_M_D, Constants::M_D_Y, Constants::D_M_Y]),
            'email' => 'nullable|email',
            'admin_email' => 'nullable|email',
            'telephone' => 'nullable|string',
            'address_line_one' => 'nullable|string',
            'address_line_two' => 'nullable|string',
            'floor' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'domain_admin_portal' => 'nullable|string',
            'http_protocol' => 'nullable|string',
            'support_email' => 'nullable|email',
            'support_telephone' => 'nullable|string',
            'sms_service_base_url' => 'nullable|url',
            'sms_service_api_key' => 'nullable|string',
            'sms_service_sender_id' => 'nullable|string',
            'otp_expiry_time_minutes' => 'nullable|integer',
            'sms_rate' => 'nullable|integer',
            'free_sms_quantity' => 'nullable|integer'
        ];
    }

    private function validateCountry($attribute, $value, $fail)
    {
        $country = Country::find($value);
        if ($value!= NULL && !$country) {
            $fail(__('validation.custom.configuration.country_id.exists'));
        }
    }

    public function messages(): array
    {
        return [
            'name.string' => __('validation.custom.configuration.name.string'),
            'organization_number.numeric' => __('validation.custom.configuration.organization_number.numeric'),
            'date_format.string' => __('validation.custom.configuration.date_format.string'),
            'date_format.in' => __('validation.custom.configuration.date_format.in'),
            'email.email' => __('validation.custom.configuration.email.email'),
            'admin_email.email' => __('validation.custom.configuration.admin_email.email'),
            'telephone.string' => __('validation.custom.configuration.telephone.string'),
            'address_line_one.string' => __('validation.custom.configuration.address_line_one.string'),
            'address_line_two.string' => __('validation.custom.configuration.address_line_two.string'),
            'floor.string' => __('validation.custom.configuration.floor.string'),
            'city.string' => __('validation.custom.configuration.city.string'),
            'state.string' => __('validation.custom.configuration.state.string'),
            'zip_code.string' => __('validation.custom.configuration.zip_code.string'),
            'domain_admin_portal.string' => __('validation.custom.configuration.domain_admin_portal.string'),
            'http_protocol.string' => __('validation.custom.configuration.http_protocol.string'),
            'support_email.email' => __('validation.custom.configuration.support_email.email'),
            'support_telephone.string' => __('validation.custom.configuration.support_telephone.string'),
            'support_telephone.nullable' => __('validation.custom.configuration.support_telephone.nullable'),
            'sms_service_base_url.url' => __('validation.custom.configuration.sms_service_base_url.url'),
            'sms_service_api_key.string' => __('validation.custom.configuration.sms_service_api_key.string'),
            'sms_service_sender_id.string' => __('validation.custom.configuration.sms_service_sender_id.string'),
            'otp_expiry_time_minutes.integer' => __('validation.custom.configuration.otp_expiry_time_minutes.integer'),
            'sms_rate.integer' => __('validation.custom.configuration.sms_rate.integer'),
            'free_sms_quantity.integer' => __('validation.custom.configuration.free_sms_quantity.integer')
        ];
    }
}
