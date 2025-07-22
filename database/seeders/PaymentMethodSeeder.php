<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_methods')->truncate();
        $paymentMethods = [
            [
                'name' => 'BKash',
                'slug' => 'bkash',
                'logo' => asset('media/payment/bkash_logo.png'),
                'base_url' => 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout',
                'app_key' => '0vWQuCRGiUX7EPVjQDr0EUAYtc',
                'app_secret' => 'jcUNPBgbcqEDedNKdvE4G1cAK7D3hCjmJccNPZZBq96QIxxwAMEx',
                'username' => '01770618567',
                'password' => 'D7DaC<*E*eG',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('payment_methods')->insert($paymentMethods);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
