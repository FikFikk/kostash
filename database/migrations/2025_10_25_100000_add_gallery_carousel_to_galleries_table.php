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
        Schema::table('galleries', function (Blueprint $table) {
            $table->boolean('is_gallery')->default(false)->after('description');
            $table->boolean('is_carousel')->default(false)->after('is_gallery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'is_gallery')) {
                $table->dropColumn('is_gallery');
            }
            if (Schema::hasColumn('galleries', 'is_carousel')) {
                $table->dropColumn('is_carousel');
            }
        });
    }
};
