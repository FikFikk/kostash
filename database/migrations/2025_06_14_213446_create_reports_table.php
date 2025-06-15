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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('room_id');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['electrical', 'water', 'facility', 'cleaning', 'security', 'other']);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->json('images')->nullable();
            $table->timestamp('reported_at')->useCurrent();
            $table->timestamps(); 

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            // Indexes
            $table->index('user_id', 'idx_user_id');
            $table->index('room_id', 'idx_room_id');
            $table->index('status', 'idx_status');
            $table->index('category', 'idx_category');
            $table->index('reported_at', 'idx_reported_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
