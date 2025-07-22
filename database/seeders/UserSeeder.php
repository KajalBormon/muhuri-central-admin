<?php

namespace Database\Seeders;

use App\Models\User;
use App\Constants\Constants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@nonditosoft.com',
            'password' => Hash::make('12345'),
        ]);
        $user->assignRole(Constants::ROLE_SUPER_ADMIN);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
