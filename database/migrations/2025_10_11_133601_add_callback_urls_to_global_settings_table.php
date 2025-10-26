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
            $table->string('payment_notification_url')->nullable()->after('payment_merchant_id');
            $table->string('payment_finish_url')->nullable()->after('payment_notification_url');
            $table->string('payment_unfinish_url')->nullable()->after('payment_finish_url');
            $table->string('payment_error_url')->nullable()->after('payment_unfinish_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_notification_url',
                'payment_finish_url',
                'payment_unfinish_url',
                'payment_error_url'
            ]);
        });
    }
};
