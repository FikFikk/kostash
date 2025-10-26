<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('meters')->insert([
            [
                'id' => '14c6236c-94ad-47d3-a56a-fa22e100649c',
                'room_id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'water_meter_start' => 671,
                'water_meter_end' => 676,
                'electric_meter_start' => 200,
                'electric_meter_end' => 210,
                'period' => '2025-05-07',
                'created_at' => '2025-05-11 05:07:05',
                'updated_at' => '2025-05-11 05:56:06',
                'total_water' => 5,
                'total_electric' => 10,
                'total_bill' => 505000,
                'user_id' => 'd77b000b-6830-4978-ab32-d0dc980a932c'
            ],
            [
                'id' => '2f152d7a-f4ef-430e-bb9a-5204f0dbe05c',
                'room_id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'water_meter_start' => 660,
                'water_meter_end' => 671,
                'electric_meter_start' => 247,
                'electric_meter_end' => 250,
                'period' => '2025-08-07',
                'created_at' => '2025-05-26 11:58:10',
                'updated_at' => '2025-05-26 12:41:56',
                'total_water' => 11,
                'total_electric' => 3,
                'total_bill' => 541000,
                'user_id' => 'ba3af76a-3953-49f1-92c1-9240b314ddce'
            ],
            [
                'id' => '2f82fb25-18f1-4330-b23c-2859a75f058f',
                'room_id' => 'bf928a98-c548-4171-b8cc-f718e10d38e2',
                'water_meter_start' => 220,
                'water_meter_end' => 230,
                'electric_meter_start' => 600,
                'electric_meter_end' => 610,
                'period' => '2025-04-07',
                'created_at' => '2025-05-26 13:06:34',
                'updated_at' => '2025-05-26 13:06:34',
                'total_water' => 10,
                'total_electric' => 10,
                'total_bill' => 550000,
                'user_id' => 'f9c7f27d-3a2f-11f0-8bb1-d8bbc11eb72d'
            ],
            [
                'id' => '4b5825c1-6081-4532-b5fd-37bae3f3ebb1',
                'room_id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'water_meter_start' => 660,
                'water_meter_end' => 671,
                'electric_meter_start' => 195,
                'electric_meter_end' => 200,
                'period' => '2025-04-07',
                'created_at' => '2025-04-07 10:45:43',
                'updated_at' => '2025-05-20 10:45:43',
                'total_water' => 11,
                'total_electric' => 5,
                'total_bill' => 554495,
                'user_id' => 'd77b000b-6830-4978-ab32-d0dc980a932c'
            ],
            [
                'id' => '52076ef0-11e6-4ead-b124-be27f76212c0',
                'room_id' => '38d453a8-8fa3-4784-a811-52aa1dd441d3',
                'water_meter_start' => 210,
                'water_meter_end' => 215,
                'electric_meter_start' => 603,
                'electric_meter_end' => 615,
                'period' => '2025-05-07',
                'created_at' => '2025-05-26 13:08:18',
                'updated_at' => '2025-05-26 13:08:18',
                'total_water' => 5,
                'total_electric' => 12,
                'total_bill' => 496000,
                'user_id' => '39ae91fb-3118-4b80-a770-a2eed6ff3238'
            ],
            [
                'id' => '685789fc-769e-4311-b7cb-023fc131620f',
                'room_id' => 'bf928a98-c548-4171-b8cc-f718e10d38e2',
                'water_meter_start' => 230,
                'water_meter_end' => 235,
                'electric_meter_start' => 610,
                'electric_meter_end' => 617,
                'period' => '2025-05-07',
                'created_at' => '2025-05-26 13:07:01',
                'updated_at' => '2025-05-26 13:07:01',
                'total_water' => 5,
                'total_electric' => 7,
                'total_bill' => 481000,
                'user_id' => 'f9c7f27d-3a2f-11f0-8bb1-d8bbc11eb72d'
            ],
            [
                'id' => '75cf03b0-8ff9-49b3-87e1-843cfb104e9a',
                'room_id' => 'b030c851-a467-4035-86ae-9fd1fb59b851',
                'water_meter_start' => 230,
                'water_meter_end' => 234,
                'electric_meter_start' => 606,
                'electric_meter_end' => 614,
                'period' => '2025-05-07',
                'created_at' => '2025-05-26 13:07:35',
                'updated_at' => '2025-05-26 13:07:35',
                'total_water' => 4,
                'total_electric' => 8,
                'total_bill' => 472000,
                'user_id' => 'f9c7da30-3a2f-11f0-8bb1-d8bbc11eb72d'
            ],
            [
                'id' => '7f1c839b-6415-42d0-8510-56bc886d971c',
                'room_id' => '8101da7a-2152-4809-b33d-cf5bca981566',
                'water_meter_start' => 402,
                'water_meter_end' => 406,
                'electric_meter_start' => 304,
                'electric_meter_end' => 305,
                'period' => '2025-06-07',
                'created_at' => '2025-05-16 03:29:37',
                'updated_at' => '2025-05-17 07:21:32',
                'total_water' => 4,
                'total_electric' => 1,
                'total_bill' => 452500,
                'user_id' => '57d452fd-a40e-4166-826a-8c2b1729349f'
            ],
            [
                'id' => '7ff5caa7-992d-4649-9666-3ef17a33d8c3',
                'room_id' => '8101da7a-2152-4809-b33d-cf5bca981566',
                'water_meter_start' => 400,
                'water_meter_end' => 402,
                'electric_meter_start' => 300,
                'electric_meter_end' => 304,
                'period' => '2025-05-07',
                'created_at' => '2025-05-11 21:22:21',
                'updated_at' => '2025-05-11 21:22:21',
                'total_water' => 2,
                'total_electric' => 4,
                'total_bill' => 442000,
                'user_id' => '57d452fd-a40e-4166-826a-8c2b1729349f'
            ],
            [
                'id' => '8c674e55-e468-4dd3-a578-c43aa3571f9b',
                'room_id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'water_meter_start' => 676,
                'water_meter_end' => 679,
                'electric_meter_start' => 210,
                'electric_meter_end' => 212,
                'period' => '2025-04-07',
                'created_at' => '2025-04-07 05:58:21',
                'updated_at' => '2025-05-11 06:38:00',
                'total_water' => 3,
                'total_electric' => 2,
                'total_bill' => 445000,
                'user_id' => 'd77b000b-6830-4978-ab32-d0dc980a932c'
            ],
            [
                'id' => '9ee37334-2afb-45a0-8a8a-2c38ba7b2314',
                'room_id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'water_meter_start' => 689,
                'water_meter_end' => 691,
                'electric_meter_start' => 214,
                'electric_meter_end' => 220,
                'period' => '2025-08-07',
                'created_at' => '2025-05-21 02:47:17',
                'updated_at' => '2025-05-21 02:47:17',
                'total_water' => 2,
                'total_electric' => 6,
                'total_bill' => 450994,
                'user_id' => 'd77b000b-6830-4978-ab32-d0dc980a932c'
            ],
            [
                'id' => 'b4070241-90c6-44ed-8d61-ec14c0725f2d',
                'room_id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'water_meter_start' => 645,
                'water_meter_end' => 650,
                'electric_meter_start' => 233,
                'electric_meter_end' => 235,
                'period' => '2025-04-07',
                'created_at' => '2025-05-26 11:56:09',
                'updated_at' => '2025-05-26 11:56:09',
                'total_water' => 5,
                'total_electric' => 2,
                'total_bill' => 466000,
                'user_id' => 'ba3af76a-3953-49f1-92c1-9240b314ddce'
            ],
            [
                'id' => 'c4a69667-9377-48fb-81d8-0c6f758f38c0',
                'room_id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'water_meter_start' => 653,
                'water_meter_end' => 655,
                'electric_meter_start' => 240,
                'electric_meter_end' => 245,
                'period' => '2025-06-07',
                'created_at' => '2025-05-16 04:36:42',
                'updated_at' => '2025-05-16 05:26:43',
                'total_water' => 2,
                'total_electric' => 5,
                'total_bill' => 446500,
                'user_id' => 'ba3af76a-3953-49f1-92c1-9240b314ddce'
            ],
            [
                'id' => 'd9a72fb6-4804-40f1-b07a-3915ea2834a2',
                'room_id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'water_meter_start' => 655,
                'water_meter_end' => 660,
                'electric_meter_start' => 245,
                'electric_meter_end' => 247,
                'period' => '2025-07-07',
                'created_at' => '2025-05-16 05:27:56',
                'updated_at' => '2025-05-16 07:38:56',
                'total_water' => 5,
                'total_electric' => 2,
                'total_bill' => 469000,
                'user_id' => 'ba3af76a-3953-49f1-92c1-9240b314ddce'
            ],
            [
                'id' => 'e81f2c9c-5afc-4fd7-8dd2-0a0728b10e78',
                'room_id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'water_meter_start' => 650,
                'water_meter_end' => 653,
                'electric_meter_start' => 235,
                'electric_meter_end' => 240,
                'period' => '2025-05-07',
                'created_at' => '2025-05-11 20:43:24',
                'updated_at' => '2025-05-11 20:43:24',
                'total_water' => 3,
                'total_electric' => 5,
                'total_bill' => 458500,
                'user_id' => 'ba3af76a-3953-49f1-92c1-9240b314ddce'
            ],
            [
                'id' => 'faad2bd9-ee01-4049-ac18-6322105ec0ac',
                'room_id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'water_meter_start' => 679,
                'water_meter_end' => 689,
                'electric_meter_start' => 212,
                'electric_meter_end' => 214,
                'period' => '2025-07-07',
                'created_at' => '2025-05-11 22:53:27',
                'updated_at' => '2025-05-17 07:49:57',
                'total_water' => 10,
                'total_electric' => 2,
                'total_bill' => 529000,
                'user_id' => 'd77b000b-6830-4978-ab32-d0dc980a932c'
            ]
        ]);
    }
}