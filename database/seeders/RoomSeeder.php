<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'id' => Str::uuid(),
            'name' => 'Kamar 1',
            'image' => 'rooms/kamar1.jpg',
            'width' => 3.5,
            'length' => 5.0,
            'description' => 'Kamar nyaman dengan pencahayaan alami.',
            'facilities' => json_encode([
                'AC',
                'Wi-Fi',
                'Kamar Mandi Dalam',
                'Kasur Queen Size'
            ]),
        ]);

        Room::create([
            'id' => Str::uuid(),
            'name' => 'Kamar 2',
            'image' => 'rooms/kamar2.jpg',
            'width' => 3.5,
            'length' => 5.0,
            'description' => 'Kamar luas dekat dengan dapur umum.',
            'facilities' => json_encode([
                'Kipas Angin',
                'Wi-Fi',
                'Lemari Pakaian',
                'Meja Belajar'
            ]),
        ]);
    }
}
