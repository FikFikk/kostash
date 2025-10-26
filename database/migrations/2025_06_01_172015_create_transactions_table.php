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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id')->unique();
            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('meter_id')->constrained();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'expired', 'cancelled', 'challenge'])->default('pending');
            $table->string('payment_type')->nullable();
            $table->string('snap_token')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
