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
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignUuid('meter_id')->nullable()->constrained('meters')->nullOnDelete();
            $table->integer('room_charge');
            $table->integer('water_charge');
            $table->integer('electric_charge');
            $table->integer('total_amount');
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->date('period'); // e.g., 2025-04-01 for April
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
