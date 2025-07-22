<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('company_categories')->truncate();
        DB::table('company_categories')->insert([
            [
                'id' => 1,
                'name' => 'Shrimp Larvae Hatchery',
                'name_bn' => 'চিংড়ি পোনা হ্যাচারি',
                'slug' => 'shrimp-larvae-hatchery',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name' => 'Shrimp Larvae Shop',
                'name_bn' => 'চিংড়ি পোনা ঘর',
                'slug' => 'shrimp-larvae-shop',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
