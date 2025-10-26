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
        Schema::table('transactions', function (Blueprint $table) {
            // Remove Midtrans field if exists
            if (Schema::hasColumn('transactions', 'snap_token')) {
                $table->dropColumn('snap_token');
            }

            // Add Mayar fields
            $table->string('mayar_payment_id')->nullable()->after('order_id');
            $table->string('mayar_link')->nullable()->after('mayar_payment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Remove Mayar fields
            $table->dropColumn(['mayar_payment_id', 'mayar_link']);

            // Restore Midtrans field
            $table->string('snap_token')->nullable()->after('order_id');
        });
    }
};
