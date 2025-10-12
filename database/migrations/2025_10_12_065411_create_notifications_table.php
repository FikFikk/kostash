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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // transaction, report, payment, general
            $table->string('notifiable_id'); // user_id yang menerima notifikasi (UUID)
            $table->string('notifiable_type')->default('App\Models\User'); // model type
            $table->json('data'); // data notifikasi (title, message, url, icon, etc)
            $table->timestamp('read_at')->nullable(); // kapan dibaca
            $table->timestamps();

            $table->index(['notifiable_id', 'notifiable_type']);
            $table->index('read_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
