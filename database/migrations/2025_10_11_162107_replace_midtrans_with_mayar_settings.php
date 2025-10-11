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
            // Try to drop Midtrans fields if they exist
            $columnsToCheck = [
                'payment_server_key',
                'payment_client_key',
                'payment_merchant_id',
                'payment_notification_url',
                'payment_finish_url',
                'payment_unfinish_url',
                'payment_error_url'
            ];

            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('global_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('global_settings', function (Blueprint $table) {
            // Update payment_type to use Mayar by default
            $table->string('payment_type')->default('mayar')->change();

            // Add Mayar fields if they don't exist
            if (!Schema::hasColumn('global_settings', 'mayar_api_key')) {
                $table->text('mayar_api_key')->nullable()->after('payment_type');
            }
            if (!Schema::hasColumn('global_settings', 'mayar_webhook_token')) {
                $table->string('mayar_webhook_token')->nullable()->after('mayar_api_key');
            }
            if (!Schema::hasColumn('global_settings', 'mayar_redirect_url')) {
                $table->string('mayar_redirect_url')->nullable()->after('mayar_webhook_token');
            }
            if (!Schema::hasColumn('global_settings', 'mayar_sandbox')) {
                $table->boolean('mayar_sandbox')->default(true)->after('mayar_redirect_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            // Remove Mayar fields
            $columnsToRemove = [
                'mayar_api_key',
                'mayar_webhook_token',
                'mayar_redirect_url',
                'mayar_sandbox'
            ];

            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('global_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
