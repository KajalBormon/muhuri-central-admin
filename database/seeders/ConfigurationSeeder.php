<?php

namespace Database\Seeders;

use App\Constants\Constants;
use App\Models\Configuration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('configurations')->truncate();
        $configurations = [
            [
                'option_name' => 'name',
                'option_value' => ''
            ],
            [
                'option_name' => 'organization_number',
                'option_value' => 0
            ],
            [
                'option_name' => 'country_id',
                'option_value' => 18
            ],
            [
                'option_name' => 'date_format',
                'option_value' => Constants::Y_M_D
            ],
            [
                'option_name' => 'logo',
                'option_value' => ''
            ],
            [
                'option_name' => 'favicon',
                'option_value' => ''
            ],
            [
                'option_name' => 'login_page_background_image',
                'option_value' => ''
            ],
            [
                'option_name' => 'email',
                'option_value' => ''
            ],
            [
                'option_name' => 'admin_email',
                'option_value' => ''
            ],
            [
                'option_name' => 'telephone',
                'option_value' => ''
            ],

            [
                'option_name' => 'address_line_one',
                'option_value' => ''
            ],
            [
                'option_name' => 'address_line_two',
                'option_value' => ''
            ],
            [
                'option_name' => 'floor',
                'option_value' => ''
            ],
            [
                'option_name' => 'city',
                'option_value' => ''
            ],
            [
                'option_name' => 'state',
                'option_value' => ''
            ],
            [
                'option_name' => 'zip_code',
                'option_value' => ''
            ],
            [
                'option_name' => 'email_provider_id',
                'option_value' => 1
            ],
            [
                'option_name' => 'domain_admin_portal',
                'option_value' => 'dev.muhuri.app'
            ],
            [
                'option_name' => 'http_protocol',
                'option_value' => 'https'
            ],
            [
                'option_name' => 'support_email',
                'option_value' => 'support@muhuri.app'
            ],
            [
                'option_name' => 'support_telephone',
                'option_value' => '+8801673628369'
            ],
            [
                'option_name' => 'sms_service_base_url',
                'option_value' => 'https://bulksmsbd.net/api/smsapi',
            ],
            [
                'option_name' => 'sms_service_api_key',
                'option_value' => '0FkewrJVzaCvpQtpFhKM',
            ],
            [
                'option_name' => 'sms_service_sender_id',
                'option_value' => '8809617611758',
            ],
            [
                'option_name' => 'otp_expiry_time_minutes',
                'option_value' => 2
            ],
            [
                'option_name' => 'sms_rate',
                'option_value' => 2
            ],
            [
                'option_name' => 'free_sms_quantity',
                'option_value' => 100
            ]
        ];

        foreach ($configurations as $configuration) {
            Configuration::create($configuration);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

