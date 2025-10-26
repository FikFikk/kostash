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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('image')->nullable();
            $table->decimal('width', 5, 2)->nullable();
            $table->decimal('length', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->json('facilities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
