<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->string('sec_fetch_site')->nullable()->after('referer');
            $table->string('sec_fetch_mode')->nullable()->after('sec_fetch_site');
            $table->string('sec_fetch_user')->nullable()->after('sec_fetch_mode');
            $table->string('accept_language')->nullable()->after('sec_fetch_user');
            $table->json('headers_json')->nullable()->after('accept_language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn([
                'sec_fetch_site',
                'sec_fetch_mode',
                'sec_fetch_user',
                'accept_language',
                'headers_json'
            ]);
        });
    }
};
