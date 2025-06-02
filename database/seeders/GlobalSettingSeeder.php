<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('global_settings')->insert([
            [
                'id' => 1,
                'monthly_room_price' => 400000,
                'water_price' => 12000,
                'electric_price' => 3000,
                'created_at' => '2025-04-30 21:24:55',
                'updated_at' => '2025-05-21 02:48:20'
            ]
        ]);
    }
}