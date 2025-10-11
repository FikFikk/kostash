<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->string('mayar_api_key')->nullable();
            $table->string('mayar_webhook_token')->nullable();
            $table->string('mayar_redirect_url')->nullable();
            $table->boolean('mayar_sandbox')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn(['mayar_api_key', 'mayar_webhook_token', 'mayar_redirect_url', 'mayar_sandbox']);
        });
    }
};
