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
        Schema::table('global_settings', function (Blueprint $table) {
            // Additional pricing columns
            $table->integer('deposit_amount')->nullable()->after('electric_price');
            $table->decimal('late_fee_percentage', 5, 2)->default(0)->after('deposit_amount');
            $table->integer('admin_fee')->nullable()->after('late_fee_percentage');

            // Email & SMTP settings (yang belum ada di migration sebelumnya)
            $table->string('email_encryption')->nullable()->after('email_password');
            $table->string('email_from_address')->nullable()->after('email_encryption');
            $table->string('email_from_name')->nullable()->after('email_from_address');

            // SEO Settings
            $table->string('site_title')->nullable()->after('description');
            $table->text('site_keywords')->nullable()->after('site_title');
            $table->text('site_description')->nullable()->after('site_keywords');
            $table->string('meta_author')->nullable()->after('site_description');
            $table->string('meta_robots')->default('index,follow')->after('meta_author');
            $table->string('og_title')->nullable()->after('meta_robots');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');

            // General App Info
            $table->string('app_name')->nullable()->after('og_image');
            $table->string('app_logo')->nullable()->after('app_name');
            $table->text('kost_address')->nullable()->after('app_logo');
            $table->string('kost_phone')->nullable()->after('kost_address');
            $table->string('kost_email')->nullable()->after('kost_phone');
            $table->string('timezone')->default('Asia/Jakarta')->after('kost_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn([
                'deposit_amount',
                'late_fee_percentage',
                'admin_fee',
                'email_encryption',
                'email_from_address',
                'email_from_name',
                'site_title',
                'site_keywords',
                'site_description',
                'meta_author',
                'meta_robots',
                'og_title',
                'og_description',
                'og_image',
                'app_name',
                'app_logo',
                'kost_address',
                'kost_phone',
                'kost_email',
                'timezone'
            ]);
        });
    }
};
