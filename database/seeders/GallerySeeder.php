<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('galleries')->insert([
            [
                'id' => 1, // Jika id tidak auto-increment
                'title' => 'Foto dari luar kos',
                'filename' => 'uploads/gallery/Q6leDOOGn9tpFZfYfGh9jlzi9zaVcadonYK7N3IA.jpg',
                'uploader_name' => 'FikFikk',
                'categories' => '["view", "out"]',
                'description' => NULL,
                'created_at' => '2025-05-05 20:41:39',
                'updated_at' => '2025-05-05 20:45:53'
            ],
            [
                'id' => 2,
                'title' => 'Kamar Kos',
                'filename' => 'uploads/gallery/E3Xt7qKT86BuLrK7elRBh779XTmVBo3ZZNDqhHFs.jpg',
                'uploader_name' => 'FikFikk',
                'categories' => '["room", "in"]',
                'description' => NULL,
                'created_at' => '2025-05-05 20:44:13',
                'updated_at' => '2025-05-05 20:44:13'
            ],
            [
                'id' => 3,
                'title' => 'Pemandangan',
                'filename' => 'uploads/gallery/dEeMa4dvdix5UGdYTLIXXgr76ty4AAgGyWwSH7do.jpg',
                'uploader_name' => 'Ashari',
                'categories' => '["view"]',
                'description' => NULL,
                'created_at' => '2025-05-05 20:47:49',
                'updated_at' => '2025-05-05 20:47:49'
            ],
            [
                'id' => 5,
                'title' => 'tess',
                'filename' => 'uploads/gallery/MD9MEcByaaU7ztyntk6QuG7k3AwLVpybscuVyXQl.jpg',
                'uploader_name' => 'FikFikk',
                'categories' => '["view"]',
                'description' => 'oleolee',
                'created_at' => '2025-05-05 20:49:29',
                'updated_at' => '2025-05-05 20:57:32'
            ],
            [
                'id' => 6,
                'title' => 'Warung Tegal Kharisma',
                'filename' => 'uploads/gallery/jFTOMxzUnIxP131qs1amP66uEkp5hKsmD5rmlrfM.jpg',
                'uploader_name' => 'Ashari',
                'categories' => '["room", "facility", "surroundings", "makanan"]',
                'description' => NULL,
                'created_at' => '2025-05-05 21:32:19',
                'updated_at' => '2025-05-05 21:36:22'
            ],
            [
                'id' => 7,
                'title' => 'Makanan Sate Ayam',
                'filename' => 'uploads/gallery/z5Njs0VYugbbhA2cNijuSvjNvz7jRHSwpT39cLot.jpg',
                'uploader_name' => 'Asharii',
                'categories' => '["surroundings"]',
                'description' => NULL,
                'created_at' => '2025-05-17 22:59:42',
                'updated_at' => '2025-05-17 23:04:20'
            ]
        ]);
    }
}