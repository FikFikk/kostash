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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['tagihan', 'maintenance', 'check_in', 'check_out', 'meeting', 'reminder', 'other'])->default('other');
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->boolean('all_day')->default(false);
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->string('color', 7)->default('#3b82f6'); // Hex color for calendar display
            $table->decimal('amount', 12, 2)->nullable(); // For tagihan events
            $table->string('location')->nullable();
            $table->json('participants')->nullable(); // Store user IDs who should see this event
            $table->json('metadata')->nullable(); // Additional data like room_id, meter_id, etc
            $table->foreignUuid('created_by')->constrained('users');
            $table->foreignUuid('assigned_to')->nullable()->constrained('users');
            $table->boolean('is_recurring')->default(false);
            $table->json('recurrence_pattern')->nullable(); // For recurring events
            $table->datetime('reminder_at')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();

            // Indexes for better performance
            $table->index(['start_date', 'end_date']);
            $table->index(['type', 'status']);
            $table->index(['created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
