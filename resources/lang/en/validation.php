<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],

        'configuration' => [
            'name' => [
                'string' => 'Company name must be a string'
            ],
            'date_format' => [
                'string' => 'Date format must be a string',
                'in' => 'Selected date format is invalid'
            ],
            'organization_number' => [
                'numeric' => 'Organization number must be numeric',
                'unique' => 'Organization number has already been taken'
            ],
            'email' => [
                'email' => 'Please provide a valid email',
                'unique' => 'Email has already been taken'
            ],
            'admin_email' => [
                'email' => 'Please provide a valid email',
                'unique' => 'Admin email has already been taken'
            ],
            'telephone' => [
                'string' => 'Telephone number must be a string'
            ],
            'country_id' => [
                'exists' => 'Selected country does not exist'
            ],
            'address_line_one' => [
                'string' => 'Address line one must be a string'
            ],
            'address_line_two' => [
                'string' => 'Address line two must be a string'
            ],
            'floor' => [
                'string' => 'Floor\'s number must be a string'
            ],
            'city' => [
                'string' => 'City\'s name must be a string'
            ],
            'state' => [
                'string' => 'State\'s name must be a string'
            ],
            'zip_code' => [
                'string' => 'Zip code must be a string'
            ],
            'domain_admin_portal' => [
                'string' => 'Domain admin portal must be string',
            ],
            'http_protocol' => [
                'string' => 'HTTP protocol must be string',
            ],
            'support_email' => [
                'email' => 'Support email must be a valid email',
            ],
            'support_telephone' => [
                'string' => 'Support telephone must be string',
            ],
            'sms_service_base_url' => [
                'url' => 'SMS service base url must be a valid URL'
            ],
            'sms_service_api_key' => [
                'string' => 'SMS service api key must be a string'
            ],
            'sms_service_sender_id' => [
                'string' => 'SMS service sender id must be a string'
            ],
            'otp_expiry_time_minutes' => [
                'integer' => 'OTP expiry time minutes should be an integer'
            ],
            'sms_rate' => [
                'integer' => 'SMS rate should be an integer'
            ],
            'free_sms_quantity' => [
                'integer' => 'Free SMS quantity should be an integer'
            ]
        ],

        'permission' => [
            'name' => [
                'required' => 'Name is required',
                'unique' => 'The combination of name and guard name must be unique.'
            ],
            'group_name' => [
                'required' => 'Group name is required'
            ],
            'display_name' => [
                'required' => 'Display name is required'
            ]
        ],

        'user' => [
            'name' => [
                'required' => 'Name is required'
            ],
            'email' => [
                'required' => 'Email is required',
                'email' => 'Please provide a valid email',
                'unique' => 'Email has already been taken',
            ],
            'current_password' => [
                'required' => 'Current password is required',
                'current_password' => 'Current password is incorrect'
            ],
            'password' => [
                'required' => 'New password is required'
            ],
            'password_confirmation' => [
                'required' => 'Password confirmation is required',
                'same' => 'Password confirmation does not match'
            ]
        ],

        'role' => [
            'name' => [
                'required' => 'Name is required',
                'unique' => 'Name already exists'
            ],
            'permission_ids' => [
                'array' => 'Permissions must be an array'
            ],
            'permission_id' => [
                'required' => 'Permission is required',
                'exists' => 'Selected permission does not exist'
            ],
            'user_id' => [
                'required' => 'User is required',
                'exists' => 'Selected user does not exist'
            ],
            'role_id' => [
                'required' => 'Role is required',
                'exists' => 'Selected role does not exist'
            ]
        ],

        'brand' => [
            'name' =>[
                'required' => 'Brand is required',
                'string' => 'Brand must be a string',
                'max' => 'Brand must be within 255 characters'
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
    'name_required' => 'Name is required',
    'email_required' => 'Email is required',
    'domain_required' => 'Domain is required',
    'workspace_required' => 'Workspace is required',
    'password_required' => 'Password is required',
    'password_confirmation_required' => 'Password confirmation is required',
    'tenant_id_required' => 'Tenant ID is required',
    'db_name_required' => 'Database name is required',
    'db_username_required' => 'Database username is required',
    'db_password_required' => 'Database password is required',
    'db_host_required' => 'Database host is required',
    'db_port_required' => 'Database port is required',
    'db_type_required' => 'Database type is required'

];
