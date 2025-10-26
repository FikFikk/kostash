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
        DB::table('global_settings')->updateOrInsert(
            ['id' => 1],
            [
                'monthly_room_price' => 400000,
                'water_price' => 12000,
                'electric_price' => 3000,

                // Mayar Configuration for sandbox testing
                'mayar_api_key' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI1YjcxZTExMS0zNGIyLTQ3MWQtYjM5Zi01YTg2YmY3ZWM3YzYiLCJhY2NvdW50SWQiOiIyMDkxMGYxNS01N2QxLTRiNzYtYjE1YS02OWRlYWZlMzRjNjUiLCJjcmVhdGVkQXQiOiIxNzYwMTcxODMzNTg3Iiwicm9sZSI6ImRldmVsb3BlciIsInN1YiI6ImZpa3JpMjI1NDU2QGdtYWlsLmNvbSIsIm5hbWUiOiJQaXh0aXZlIiwibGluayI6ImZpa2Zpa2siLCJpc1NlbGZEb21haW4iOmZhbHNlLCJpYXQiOjE3NjAxNzE4MzN9.auF42amWDI9dQioPVqcJA_KApZ_Wr_w7cEAiri7bJOcn9EWlh7RRo4OGXBC78ajDLHQ4N1Xl2DFOkORq4riy_jicHGuX85POUy-OMOpU8ciu-eEizQFG6zixWc8eJd-0nw-xGbYfvgEIY825nJjz7DxbKgGXdJipGIeynneYI1ETZ_iiP9CVVCe0mtkyNbxGhK7vC2HwHZ2mclbfzg7pND960KitG6pa5wrDGdz8X6dxSefd3C8lQa2vHzcuSruMfscDeyw6KY_B8QKezgIxP3131F7gIZLgxFnrdnGIVVJ50GeWm80FaFlRl4QdaAtpO0BV38UYAJXPYbdRCIo8Fw', // This should be replaced with real API key
                'mayar_webhook_token' => '2614b16cd03b270989abe8c0fdf5e3be57e34bb37d65f370f9de155cfd013c16b3a338db777e446f41f3f25af86ac0d89dd472f2e365c2531d9e68560338751f',
                'mayar_redirect_url' => 'http://127.0.0.1:8000/payment/success',
                'mayar_sandbox' => true,
                'payment_type' => 'mayar',

                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
