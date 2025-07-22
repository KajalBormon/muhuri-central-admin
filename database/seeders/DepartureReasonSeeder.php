<?php

namespace Database\Seeders;

use App\Models\DepartureReason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartureReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('departure_reasons')->truncate();
        $departureReasons = [
            [
                'id' => 1,
                'name' => 'Fired',
                'slug' => 'fired',
                'is_active' => true,
                'is_editable' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Resigned',
                'slug' => 'resigned',
                'is_active' => true,
                'is_editable' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Retired',
                'slug' => 'retired',
                'is_active' => true,
                'is_editable' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DepartureReason::insert($departureReasons);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

