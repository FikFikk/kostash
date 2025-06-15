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
        Schema::create('report_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('report_id');
            $table->uuid('admin_id');
            $table->text('response_text');
            $table->text('action_taken')->nullable();
            $table->dateTime('estimated_completion')->nullable();
            $table->dateTime('actual_completion')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('report_id', 'idx_report_id');
            $table->index('admin_id', 'idx_admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_responses');
    }
};
