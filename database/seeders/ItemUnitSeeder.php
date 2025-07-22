<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('item_units')->truncate();
        DB::table('item_units')->insert([
            [
                'id' => 1,
                'item_id' => 1,
                'name' => 'thousand',
                'value' => 1000,
                'display_name' => 'হাজার',
                'form_display_name' => 'প্রতি হাজারের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 2,
                'item_id' => 2,
                'name' => 'thousand',
                'value' => 1000,
                'display_name' => 'হাজার',
                'form_display_name' => 'প্রতি হাজারের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 3,
                'item_id' => 3,
                'name' => 'million',
                'value' => 1,
                'display_name' => 'মিলিয়ন',
                'form_display_name' => 'প্রতি মিলিয়নের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 4,
                'item_id' => 4,
                'name' => 'million',
                'value' => 1,
                'display_name' => 'মিলিয়ন',
                'form_display_name' => 'প্রতি মিলিয়নের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 5,
                'item_id' => 5,
                'name' => 'piece',
                'value' => 1,
                'display_name' => 'পিস',
                'form_display_name' => 'প্রতি পিসের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 6,
                'item_id' => 6,
                'name' => 'piece',
                'value' => 1,
                'display_name' => 'পিস',
                'form_display_name' => 'প্রতি পিসের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 7,
                'item_id' => 8,
                'name' => 'piece',
                'value' => 1,
                'display_name' => 'পিস',
                'form_display_name' => 'প্রতি পিসের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            // other sale item unit will be added here

            //purchase item unit
            [
                'id' => 19,
                'item_id' => 19,
                'name' => 'thousand',
                'value' => 1000,
                'display_name' => 'হাজার',
                'form_display_name' => 'প্রতি হাজারের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 20,
                'item_id' => 20,
                'name' => 'thousand',
                'value' => 1000,
                'display_name' => 'হাজার',
                'form_display_name' => 'প্রতি হাজারের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 21,
                'item_id' => 21,
                'name' => 'piece',
                'value' => 1,
                'display_name' => 'পিস',
                'form_display_name' => 'প্রতি পিসের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 22,
                'item_id' => 22,
                'name' => 'piece',
                'value' => 1,
                'display_name' => 'পিস',
                'form_display_name' => 'প্রতি পিসের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 23,
                'item_id' => 23,
                'name' => 'million',
                'value' => 1,
                'display_name' => 'মিলিয়ন',
                'form_display_name' => 'প্রতি মিলিয়নের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
            [
                'id' => 24,
                'item_id' => 24,
                'name' => 'million',
                'value' => 1,
                'display_name' => 'মিলিয়ন',
                'form_display_name' => 'প্রতি মিলিয়নের দাম',
                'created_at' => '2023-06-30 11:35:51',
                'updated_at' => '2023-06-30 11:35:51',
                'deleted_at' => NULL,
            ],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
