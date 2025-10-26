<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'id' => '38d453a8-8fa3-4784-a811-52aa1dd441d3',
                'name' => 'Kamar 5',
                'image' => 'uploads/rooms/o88EqKvmRzscxastySwAOyvAwdYFozg6B2cYyb1R.jpg',
                'width' => 3.50,
                'length' => 5.00,
                'description' => NULL,
                'status' => 'available',
                'facilities' => '["s,a"]',
                'created_at' => '2025-04-29 05:14:57',
                'updated_at' => '2025-05-01 05:06:46'
            ],
            [
                'id' => '8101da7a-2152-4809-b33d-cf5bca981566',
                'name' => 'Kamar 6',
                'image' => 'uploads/rooms/XriwIRMyC87fqG8QGbA8Bwe72oyjJqzSqudsIq4C.jpg',
                'width' => 3.50,
                'length' => 5.00,
                'description' => NULL,
                'status' => 'available',
                'facilities' => '["Kamar Mandi,Ksasur Lantai,Lemari Rak"]',
                'created_at' => '2025-04-29 06:23:32',
                'updated_at' => '2025-05-02 21:46:28'
            ],
            [
                'id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'name' => 'Kamar 1',
                'image' => 'uploads/rooms/uqRT2w0xWO05xk1hQcYwQBki01buw36c7OVlSULx.jpg',
                'width' => 3.50,
                'length' => 5.00,
                'description' => 'Kamar nyaman dengan pencahayaan alami.',
                'status' => 'available',
                'facilities' => '["AC,Kamar Mandi Dalam,Kasur Lantai"]',
                'created_at' => '2025-04-28 07:44:12',
                'updated_at' => '2025-04-30 21:50:28'
            ],
            [
                'id' => 'b030c851-a467-4035-86ae-9fd1fb59b851',
                'name' => 'Kamar 4',
                'image' => 'uploads/rooms/78cRD0XGkBeeshx6p8YmPi48vRFXWH3t9eahhCPq.png',
                'width' => 3.50,
                'length' => 5.00,
                'description' => NULL,
                'status' => 'available',
                'facilities' => '["Kasur Lantai,Lemari Baju,Keset"]',
                'created_at' => '2025-04-29 05:03:58',
                'updated_at' => '2025-04-29 05:03:58'
            ],
            [
                'id' => 'bf928a98-c548-4171-b8cc-f718e10d38e2',
                'name' => 'Kamar 3',
                'image' => 'uploads/rooms/tjN0g9COZu9NkIQ3PRVTuEX5XYm57eIT98btgUsB.png',
                'width' => 3.50,
                'length' => 5.00,
                'description' => NULL,
                'status' => 'available',
                'facilities' => '["Kasur Lantai,Lemari Baju,Keset"]',
                'created_at' => '2025-04-29 04:46:13',
                'updated_at' => '2025-04-29 04:46:13'
            ],
            [
                'id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'name' => 'Kamar 2',
                'image' => 'uploads/rooms/6l7jQPJTOFKcuo6qlzNzfRzKnucybs8KWhJgBp0z.png',
                'width' => 3.50,
                'length' => 5.00,
                'description' => 'Kamar luas dekat dengan dapur umum.',
                'status' => 'available',
                'facilities' => '["Kipas Angin,Wi-Fi,Lemari Pakaian"]',
                'created_at' => '2025-04-28 07:44:12',
                'updated_at' => '2025-05-01 03:33:15'
            ]
        ]);
    }
}