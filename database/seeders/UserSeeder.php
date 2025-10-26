<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => '39ae91fb-3118-4b80-a770-a2eed6ff3238',
                'name' => 'ashari',
                'email' => 'ashari@gmail.com',
                'photo' => NULL,
                'phone' => NULL,
                'nik' => NULL,
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'tenants',
                'password' => '$2y$12$PcOtgCjku5Zb/CUSxudnsOfq/G7fanDWgO7goiHOCUYWnpic0ZSpK',
                'provider' => NULL,
                'provider_id' => NULL,
                'provider_token' => NULL,
                'room_id' => '38d453a8-8fa3-4784-a811-52aa1dd441d3',
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2025-05-02 21:37:53',
                'updated_at' => '2025-05-02 21:37:53'
            ],
            [
                'id' => '4fd50c58-e135-4876-899f-6b1969f7fddc',
                'name' => 'Test User',
                'email' => 'test@example.com',
                'photo' => NULL,
                'phone' => NULL,
                'nik' => NULL,
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'admin',
                'password' => '$2y$12$CSmwytJFZr8MiXPebHNEmOcdCMbGBOcNSylZXBmsTZu0r/.wM1D2u',
                'provider' => NULL,
                'provider_id' => NULL,
                'provider_token' => NULL,
                'room_id' => NULL,
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => '2025-04-28 07:44:11',
                'remember_token' => 'Z0Moptxpa3C9kwpV2TbM482g8k5UZwfKFY7wETb2EZzLxqYsWePLnmj702EF',
                'created_at' => '2025-04-28 07:44:12',
                'updated_at' => '2025-04-28 07:44:12'
            ],
            [
                'id' => '57d452fd-a40e-4166-826a-8c2b1729349f',
                'name' => 'fik fikk',
                'email' => 'fikfikk14@gmail.com',
                'photo' => NULL,
                'phone' => NULL,
                'nik' => NULL,
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'tenants',
                'password' => '$2y$12$Re6fs8/sMnzYNW6WzZC.z.q2342gjiXIuTlrYsJPBoDrvM8cLAXvW',
                'provider' => NULL, // Anda memiliki provider_id dan provider_token, mungkin provider juga diisi 'google'?
                'provider_id' => '114916352767972442584',
                'provider_token' => 'ya29.a0AW4XtxhrfY2EXQ0c_e1k4A7B9_Z4E9BZdvHIbpcUlcNsOZQTrO7HWYtDrzbXEJ3H4FcGe5lNEJhuHPPJkeVPTGR1PKAnPWbq5JuDF0sjwCNowUGLsvy3WLqCo66KFS4XQ5eKfzo7vk3ggsjhv6V498NeZIguVyaQZa4hPgEsZ8oaCgYKAaYSARESFQHGX2MiTGp7eR_r4jNMGIb28UFplQ0178',
                'room_id' => '8101da7a-2152-4809-b33d-cf5bca981566',
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2025-04-15 21:36:50',
                'updated_at' => '2025-05-18 04:07:27'
            ],
            [
                'id' => 'a3b6a6ef-40dd-44ac-90dc-b93fc8e9f47e',
                'name' => 'Mochammad Fikri Dwi Fardian',
                'email' => 'fikri225456@gmail.com',
                'photo' => NULL,
                'phone' => '082264148251',
                'nik' => '123123123',
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'tenants',
                'password' => '$2y$12$KTvPb5Gun.yQqAEx0B/c8.vUSiDD9thweZ2RCRPCuCNEXU6iIWkwa',
                'provider' => NULL,
                'provider_id' => NULL,
                'provider_token' => NULL,
                'room_id' => NULL,
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2025-05-06 05:12:42',
                'updated_at' => '2025-05-14 05:12:42'
            ],
            [
                'id' => 'ba3af76a-3953-49f1-92c1-9240b314ddce',
                'name' => 'Andre',
                'email' => 'andre@gmail.com',
                'photo' => NULL,
                'phone' => '0814124124',
                'nik' => NULL,
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'tenants',
                'password' => '$2y$12$TCpNsOIhhIdjwYO.QjQHuO.S0NFyN8JMX3slUR5SWPNiib60CAmVa',
                'provider' => NULL,
                'provider_id' => NULL,
                'provider_token' => NULL,
                'room_id' => 'e5e981a6-9739-46eb-aac4-0a4cb3130530',
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2025-04-23 05:15:39',
                'updated_at' => '2025-05-30 10:41:41'
            ],
            [
                'id' => 'd77b000b-6830-4978-ab32-d0dc980a932c',
                'name' => 'Fikri gtt',
                'email' => 'fikrigtt14@gmail.com',
                'photo' => '1747997408_Screenshot_4.jpg',
                'phone' => '08222',
                'nik' => '352513',
                'address' => 'Jl. Darkun Menganti Gresik',
                'date_entry' => '2025-05-18',
                'role' => 'tenants',
                'password' => '$2y$12$JFAJF4vcLLgfO9ZnIu6cH.r15KlCJhYTgo2EI9ZtgY21C9DrvAoLa',
                'provider' => NULL, // Anda memiliki provider_id dan provider_token, mungkin provider juga diisi 'google'?
                'provider_id' => '114018778841566228413',
                'provider_token' => 'ya29.a0AW4Xtxgo91oa9o405oNU5or4B4nbOisjgvR2ND_DPgq6xYPK4_FXY-eR4guhINuY23aVYkuXqHXDJEuye-xqKMGnCFzFlzMsCUB7M8ljcWJBIi43zenwLJpmohbpNwlelK17tnS3cmHYp4mAKvv7B1XHtg6Fd8GSlUH4mNC2SfAaCgYKAXISARcSFQHGX2MiCvU2H11DByjYOA2ri-FWnQ0178',
                'room_id' => '8f5574f1-322d-4f86-9f1b-101068776f61',
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2025-04-21 19:58:44',
                'updated_at' => '2025-05-30 10:27:17'
            ],
            [
                'id' => 'f9c7da30-3a2f-11f0-8bb1-d8bbc11eb72d',
                'name' => 'bayu',
                'email' => 'bayu@gmail.com',
                'photo' => NULL,
                'phone' => NULL,
                'nik' => NULL,
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'tenants',
                'password' => '$2y$12$CSmwytJFZr8MiXPebHNEmOcdCMbGBOcNSylZXBmsTZu0r/.wM1D2u', // Password sama dengan test user, mungkin perlu diverifikasi
                'provider' => NULL,
                'provider_id' => NULL,
                'provider_token' => NULL,
                'room_id' => 'b030c851-a467-4035-86ae-9fd1fb59b851',
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL, // Data created_at dan updated_at NULL di dump
                'updated_at' => NULL
            ],
            [
                'id' => 'f9c7f27d-3a2f-11f0-8bb1-d8bbc11eb72d',
                'name' => 'sigit',
                'email' => 'sigit@gmail.com',
                'photo' => NULL,
                'phone' => NULL,
                'nik' => NULL,
                'address' => NULL,
                'date_entry' => NULL,
                'role' => 'tenants',
                'password' => '$2y$12$CSmwytJFZr8MiXPebHNEmOcdCMbGBOcNSylZXBmsTZu0r/.wM1D2u', // Password sama dengan test user, mungkin perlu diverifikasi
                'provider' => NULL,
                'provider_id' => NULL,
                'provider_token' => NULL,
                'room_id' => 'bf928a98-c548-4171-b8cc-f718e10d38e2',
                'status' => 'aktif',
                'catatan' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => NULL, // Data created_at dan updated_at NULL di dump
                'updated_at' => NULL
            ]
        ]);
    }
}