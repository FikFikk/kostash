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
        Schema::create('meters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('water_meter_start')->nullable();
            $table->integer('water_meter_end')->nullable();
            $table->integer('electric_meter_start')->nullable();
            $table->integer('electric_meter_end')->nullable();
            $table->integer('total_water')->nullable();
            $table->integer('total_electric')->nullable();
            $table->integer('total_bill')->nullable();
            $table->date('period'); // e.g., 2025-04-01 for April
            $table->enum('payment_status', ['unpaid', 'paid', 'partial'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meters');
    }
};
