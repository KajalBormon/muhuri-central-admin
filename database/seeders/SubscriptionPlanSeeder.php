<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subscription_plans')->truncate();
        DB::table('subscription_plans')->insert([
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'মাসিক',
                'slug' => 'larvae-hatchery-monthly',
                'description' => 'প্রতি মাসে',
                'price' => 300,
                'duration' => 1,
                'duration_unit' => 'months',
                'trial_duration' => 1,
                'trial_duration_unit' => 'months',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'name' => 'অর্ধ বার্ষিক',
                'slug' => 'larvae-hatchery-half-yearly',
                'description' => 'প্রতি ৬ মাসে',
                'price' => 1500,
                'duration' => 6,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'category_id' => 1,
                'name' => 'বার্ষিক',
                'slug' => 'larvae-hatchery-yearly',
                'description' => 'প্রতি ১২ মাসে',
                'price' => 2400,
                'duration' => 12,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'name' => 'মাসিক',
                'slug' => 'larvae-shop-monthly',
                'description' => 'প্রতি মাসে',
                'price' => 400,
                'duration' => 1,
                'duration_unit' => 'months',
                'trial_duration' => 1,
                'trial_duration_unit' => 'months',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'category_id' => 2,
                'name' => 'অর্ধ বার্ষিক',
                'slug' => 'larvae-shop-half-yearly',
                'description' => 'প্রতি ৬ মাসে',
                'price' => 1600,
                'duration' => 6,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'category_id' => 2,
                'name' => 'বার্ষিক',
                'slug' => 'larvae-shop-yearly',
                'description' => 'প্রতি ১২ মাসে',
                'price' => 2500,
                'duration' => 12,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
