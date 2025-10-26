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
        Schema::create('report_status_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('report_id');
            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50);
            $table->uuid('changed_by');
            $table->text('reason')->nullable();
            $table->timestamp('changed_at')->useCurrent();

            // Foreign key constraints
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index('report_id', 'idx_report_id');
            $table->index('changed_at', 'idx_changed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_status_history');
    }
};
