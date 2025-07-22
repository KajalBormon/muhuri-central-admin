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
    'phone' => ':attribute ফিল্ডে একটি ভুল নাম্বার রয়েছে ।',
    'accepted' => ':attribute গ্রহণ করা আবশ্যক।',
    'active_url' => ':attribute বৈধ URL নয়।',
    'after' => ':attribute-এর পর তারিখ থাকতে হবে :date.',
    'after_or_equal' => ':attribute-এ পরে অথবা সমান একটি তারিখ থাকতে হবে :date.',
    'alpha' => ':attribute-এ শুধুমাত্র লেটার থাকতে পারে।',
    'alpha_dash' => ':attribute-এ শুধুমাত্র লেটার, নম্বর, ড্যাশ এবং আন্ডারস্কোর থাকতে পারে।',
    'alpha_num' => ':attribute-এ শুধুমাত্র লেটার ও নম্বর থাকতে পারে।',
    'array' => ':attribute একটি সিরিয়ালে হতে হবে ',
    'before' => ':attribute-এ আগের তারিখ থাকতে হবে :date.',
    'before_or_equal' => ':attribute-এ আগের অথবা সমান একটি তারিখ থাকতে হবে :date.',
    'between' => [
        'numeric' => ':attribute অবশ্যই :min ও :max এর মধ্যে হতে হবে।',
        'file' => ':attribute অবশ্যই :min ও :max kilobyte-এর মধ্যে হতে হবে৷',
        'string' => ':attribute অবশ্যই :min ও :max ক্যারেক্টারের মধ্যে হতে হবে৷',
        'array' => ':attribute অবশ্যই :min ও :max আইটেমের মধ্যে হতে হবে',
    ],
    'boolean' => ':attribute ফিল্ড সত্য বা মিথ্যা হতে হবে।',
    'confirmed' => ':attribute কনফরমেশন মেলেনি।',
    'date' => ':attribute তারিখ বৈধ নয়।',
    'date_equals' => ':attribute একটি তারিখের সমান হতে হবে :date.',
    'date_format' => ':attribute format :format-এর সাথে মেলেনি। ',
    'different' => ':attribute এবং :other ভিন্ন হতে হবে।',
    'digits' => ':attribute হতে হবে :digits digits.',
    'digits_between' => ':attribute অবশ্যই :min ও :max digits-এর মধ্যে হতে হবে৷',
    'dimensions' => ':attribute-এর ছবির ডায়মেনশন বৈধ নয়।',
    'distinct' => ':attribute ফিল্ডের duplicate value আছে। ',
    'email' => ':attribute-এ একটি বৈধ ইমেইল ঠিকানা হতে হবে। ',
    'ends_with' => ':attribute নিম্নলিখিত একটি দিয়ে শেষ হতে হবে: :values.',
    'exists' => ':attribute বৈধ নয়',
    'file' => ':attribute একটি ফাইলে হতে হবে।',
    'filled' => ':attribute ফিল্ডের একটি মান থাকতে হবে।',
    'gt' => [
        'numeric' => ':attribute :value-এর থেকে বড় হতে হবে। ',
        'file' => ':attribute :value kilobyte-এর চেয়ে বেশি হতে হবে। ',
        'string' => ':attribute :value character-এর চেয়ে বড় হতে হবে। ',
        'array' => ':attribute-এর চেয়ে বেশি থাকতে হবে :value items।',
    ],
    'gte' => [
        'numeric' => ':attribute-এর চেয়ে বড় বা সমান হতে হবে :value.',
        'file' => ':attribute-এর চেয়ে বড় বা সমান হতে হবে :value kilobytes.',
        'string' => ':attribute-এর চেয়ে বড় বা সমান হতে হবে :value characters.',
        'array' => ':attribute-এ থাকতে হবে :value items অথবা বেশি.',
    ],
    'image' => ':attribute-এর ছবি থাকতে হবে।',
    'in' => ':attribute বৈধ নয়।',
    'in_array' => ':attribute ফিল্ড :other-এর মধ্যে বিদ্যমান নেই ',
    'integer' => ':attribute একটি পূর্ণসংখ্যা হতে হবে।',
    'ip' => ':attribute একটি বৈধ IP ঠিকানা হতে হবে।',
    'ipv4' => ':attribute একটি বৈধ IPv4 ঠিকানা হতে হবে।',
    'ipv6' => ':attribute একটি বৈধ IPv6 ঠিকানা হতে হবে।',
    'json' => ':attribute বৈধ JSON স্ট্রিং হতে হবে',
    'lt' => [
        'numeric' => ':attribute :value-এর চেয়ে কম হতে হবে।',
        'file' => ':attribute :value kilobytes-এর চেয়ে কম হতে হবে।',
        'string' => ':attribute :value characters-এর চেয়ে কম হতে হবে ',
        'array' => ':attribute :value items-এর চেয়ে কম হতে হবে।',
    ],
    'lte' => [
        'numeric' => ':attribute :value-এর চেয়ে কম বা সমান হতে হবে.',
        'file' => ':attribute :value kilobytes-এর চেয়ে কম বা সমান হতে হবে।',
        'string' => ':attribute :value characters-এর চেয়ে কম বা সমান হতে হবে .',
        'array' => ':attribute :value items-চেয়ে বেশি থাকতে হবে না। ',
    ],
    'max' => [
        'numeric' => ':attribute :max-এর থেকে বেশি নাও হতে পারে। ',
        'file' => ':attribute :max kilobytes-এর থেকে বেশি নাও হতে পারে।',
        'string' => ':attribute :max characters-এর থেকে বেশি নাও হতে পারে।',
        'array' => ':attribute :max items-এর থেকে বেশি নাও হতে পারে।',
    ],
    'mimes' => ':attribute ফাইল টাইপ হতে হবে: :values.',
    'mimetypes' => ':attribute ফাইল টাইপ হতে হবে: :values.',
    'min' => [
        'numeric' => ':attribute কমপক্ষে হতে হবে :min.',
        'file' => ':attribute কমপক্ষে হতে হবে :min kilobytes.',
        'string' => ':attribute কমপক্ষে হতে হবে :min characters.',
        'array' => ':attribute কমপক্ষে হতে হবে :min items.',
    ],
    'not_in' => ':attribute বৈধ নয়।',
    'not_regex' => ':attribute ফরমেট বৈধ নয়',
    'numeric' => ':attribute একটি সংখ্যা হতে হবে।',
    'password' => 'পাসওয়ার্ডটি ভুল।',
    'present' => ':attribute ফিল্ড উপস্থিত থাকতে হবে।',
    'regex' => ':attribute ফরমেটটি বৈধ নয়।',
    'required' => ':attribute ফিল্ড প্রয়োজন।',
    'required_if' => ':attribute ফিল্ড প্রয়োজন যখন :other হলো :value',
    'required_unless' => ':attribute ফিল্ড প্রয়োজন যদি না :other-এর মধ্যে :valuesথাকে।',
    'required_with' => ':attribute ফিল্ড প্রয়োজন হয় যখন :values উপস্থিত থাকে। ',
    'required_with_all' => ':attribute ফিল্ড প্রয়োজন হয় যখন :values উপস্থিত থাকে।',
    'required_without' => ':attribute ফিল্ড প্রয়োজন হয় যখন :values উপস্থিত না থাকে।',
    'required_without_all' => ':attribute ফিল্ড প্রয়োজন হয় যখন কোনো :values উপস্থিত থাকে না। ',
    'same' => ':attribute এবং :other অবশ্যই মিলতে হবে। ',
    'size' => [
        'numeric' => ':attribute হতে হবে :size.',
        'file' => ':attribute হতে হবে :size kilobytes.',
        'string' => ':attribute হতে হবে :size characters.',
        'array' => ':attribute হতে হবে :size items.',
    ],
    'starts_with' => ':attribute নিম্নলিখিত একটি দিয়ে শুরু করা আবশ্যক: :values.',
    'string' => ':attribute স্ট্রিং হতে হবে।',
    'timezone' => ':attribute অবশ্যই একটি বৈধ জোন হতে হবে।',
    'unique' => ':attribute ইতোমধ্যে নেওয়া হয়েছে ',
    'uploaded' => ':attribute আপলোড হতে ব্যর্থ হয়েছে.',
    'url' => ':attribute ফরম্যাট বৈধ নয়',
    'uuid' => ':attribute একটি বৈধ UUID হতে হবে। ',


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

        'dob' => [
            'date_format' => 'তারিখ yyyy-mm-dd ফরম্যাটের সাথে মেলে না।',
        ],

        'mobile' => [
            'invalid_format' => 'কনটাক্ট নম্বরের ফরম্যাট অবৈধ ',
        ],

        'no_numeric' => 'কোনো সংখ্যাজাতীয় (0-৯) মান থাকতে পারে না',
        'incorrect_password' => 'বর্তমান পাসওয়ার্ডটি সঠিক নয়।',

        'configuration' => [
            'name' => [
                'string' => 'প্রতিষ্ঠানের নাম অবশ্যই স্ট্রিং হতে হবে।'
            ],
            'date_format' => [
                'string' => 'তারিখ ফরম্যাট অবশ্যই স্ট্রিং হতে হবে',
                'in' => 'নির্বাচিত তারিখ ফরম্যাট সঠিক নয়'
            ],
            'organization_number' => [
                'numeric' => 'প্রতিষ্ঠানের নম্বর অবশ্যই সংখ্যা হতে হবে',
                'unique' => 'ইতিমধ্যে প্রতিষ্ঠানের নম্বর নেওয়া হয়েছে'
            ],
            'email' => [
                'email' => 'একটি ভ্যালিড ইমেইল প্রদান করুন',
                'unique' => 'ইতিমধ্যে ইমেইল নেওয়া হয়েছে'
            ],
            'admin_email' => [
                'email' => 'একটি ভ্যালিড ইমেইল প্রদান করুন',
                'unique' => 'অ্যাডমিন ইমেইল ইতিমধ্যে নেওয়া হয়েছে'
            ],
            'telephone' => [
                'string' => 'টেলিফোন নম্বর অবশ্যই স্ট্রিং হতে হবে'
            ],
            'country_id' => [
                'exists' => 'নির্বাচিত দেশটি পাওয়া যায়নি'
            ],
            'address_line_one' => [
                'string' => 'ঠিকানার প্রথম লাইন অবশ্যই স্ট্রিং হতে হবে'
            ],
            'address_line_two' => [
                'string' => 'ঠিকানার দ্বিতীয় লাইন অবশ্যই স্ট্রিং হতে হবে'
            ],
            'floor' => [
                'string' => 'তলার নম্বর অবশ্যই স্ট্রিং হতে হবে'
            ],
            'city' => [
                'string' => 'শহরের নাম অবশ্যই স্ট্রিং হতে হবে'
            ],
            'state' => [
                'string' => 'প্রদেশের নাম অবশ্যই স্ট্রিং হতে হবে'
            ],
            'zip_code' => [
                'string' => 'জিপ কোড অবশ্যই স্ট্রিং হতে হবে'
            ],
            'domain_admin_portal' => [
                'string' => 'ডোমেইন এডমিন পোর্টাল অবশ্যই স্ট্রিং হতে হবে',
            ],
            'http_protocol' => [
                'string' => 'এইচটিটিপি প্রোটোকল অবশ্যই স্ট্রিং হতে হবে',
            ],
            'support_email' => [
                'email' => 'সাপোর্ট ইমেইল অবশ্যই একটি ভ্যালিড ইমেইল হতে হবে',
            ],
            'support_telephone' => [
                'string' => 'সাপোর্ট টেলিফোন অবশ্যই স্ট্রিং হতে হবে',
            ],
            'sms_service_base_url' => [
                'url' => 'এসএমএস সার্ভিসের বেস ইউআরএল অবশ্যই একটি বৈধ ইউআরএল হতে হবে।'
            ],
            'sms_service_api_key' => [
                'string' => 'এসএমএস সার্ভিসের এপিআই কী অবশ্যই স্ট্রিং হতে হবে।'
            ],
            'sms_service_sender_id' => [
                'string' => 'এসএমএস সার্ভিসের সেন্ডার আইডি অবশ্যই স্ট্রিং হতে হবে।'
            ],
            'otp_expiry_time_minutes' => [
                'string' => 'ওটিপি মেয়াদ উত্তীর্ণ সময় অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।'
            ],
            'sms_rate' => [
                'integer' => 'এসএমএস এর মূল্য অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।'
            ],
            'free_sms_quantity' => [
                'integer' => 'ফ্রী এসএমএস এর পরিমাণ অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।'
            ]
        ],

        'permission' => [
            'name' => [
                'required' => 'নাম প্রয়োজন',
                'unique' => 'নাম এবং গার্ড নামের কম্বিনেশন ইতিমধ্যে নেওয়া হয়েছে'
            ],
            'group_name' => [
                'required' => 'গ্রুপ নাম প্রয়োজন'
            ],
            'display_name' => [
                'required' => 'ডিসপ্লে নাম প্রয়োজন'
            ]
        ],

        'user' => [
            'name' => [
                'required' => 'নাম প্রয়োজন'
            ],
            'email' => [
                'required' => 'ইমেইল প্রয়োজন',
                'email' => 'একটি ভ্যালিড ইমেইল প্রদান করুন',
                'unique' => 'ইতিমধ্যে ইমেইলটি নেওয়া হয়েছে'
            ],
            'current_password' => [
                'required' => 'বর্তমান পাসওয়ার্ড প্রয়োজন',
                'current_password' => 'বর্তমান পাসওয়ার্ডটি ভুল হয়েছে'
            ],
            'password' => [
                'required' => 'নতুন পাসওয়ার্ড প্রয়োজন'
            ],
            'password_confirmation' => [
                'required' => 'কনফার্মেশন পাসওয়ার্ড প্রয়োজন',
                'same' => 'কনফার্মেশন পাসওয়ার্ডটি মেলেনি।'
            ]
        ],

        'role' => [
            'name' => [
                'required' => 'নাম প্রয়োজন',
                'unique' => 'নাম ইতিমধ্যেই বিদ্যমান৷'
            ],
            'permission_ids' => [
                'array' => 'রোল অবশ্যই অ্যারে হতে হবে'
            ],
            'permission_id' => [
                'required' => 'রোল প্রয়োজন',
                'exists' => 'নির্বাচিত রোলটি পাওয়া যায়নি'
            ],
            'user_id' => [
                'required' => 'ইউজার প্রয়োজন',
                'exists' => 'নির্বাচিত ইউজারকে পাওয়া যায়নি'
            ],
            'role_id' => [
                'required' => 'রোল প্রয়োজন',
                'exists' => 'নির্বাচিত রোলটি পাওয়া যায়নি'
            ]
        ],

        'brand' => [
            'name' =>[
                'required' => 'ব্র্যান্ড আবশ্যক',
                'string' => 'ব্র্যান্ড অবশ্যই একটি স্ট্রিং হতে হবে',
                'max' => 'ব্র্যান্ডের দৈর্ঘ্য সর্বোচ্চ ২৫৫ অক্ষরের মধ্যে হতে হবে'
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

    'name_required' => 'নাম লিখুন',
    'name_not_in' => 'নাম বৈধ নয়',
    'mobile_number_required' => 'মোবাইল নম্বর লিখুন',
    'address_required' => 'ঠিকানা লিখুন',
    'mobile_number_unique' => 'মোবাইল নম্বর আগে থেকেই আছে',
    'month_required' => 'মাস প্রয়োজন',
    'year_required' => 'বছর প্রয়োজন',
    'date_required' => 'তারিখ দিন',
];
