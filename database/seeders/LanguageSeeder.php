<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('languages')->truncate();

        $languages = [
            [
                'name' => 'English',
                'code' => 'en',
            ],
            [
                'name' => 'Bengali',
                'code' => 'bn'
            ]
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
