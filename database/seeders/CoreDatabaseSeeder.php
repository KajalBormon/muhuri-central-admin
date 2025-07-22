<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('core_databases')->truncate();
        DB::table('core_databases')->insert([
            'db_type' => env('DB_CONNECTION', 'mysql'),
            'db_host' => env('DB_HOST', '127.0.0.1'),
            'db_username' => env('DB_USERNAME'),
            'db_password' => env('DB_PASSWORD'),
            'db_name' =>  'mysql',
            'db_port' => env('DB_PORT', '3306'),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
