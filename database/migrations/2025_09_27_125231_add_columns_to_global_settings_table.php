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
            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('google_redirect_uri')->nullable();
            $table->string('facebook_client_id')->nullable();
            $table->string('facebook_client_secret')->nullable();
            $table->string('facebook_redirect_uri')->nullable();
            $table->string('twitter_client_id')->nullable();
            $table->string('twitter_client_secret')->nullable();
            $table->string('twitter_redirect_uri')->nullable();
            $table->string('payment_server_key')->nullable();
            $table->string('payment_client_key')->nullable();
            $table->boolean('is_production')->default(false);
            $table->string('payment_type')->nullable();
            $table->string('email_host')->nullable();
            $table->integer('email_port')->nullable();
            $table->string('email_username')->nullable();
            $table->string('email_password')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn([
                'google_client_id',
                'google_client_secret',
                'google_redirect_uri',
                'facebook_client_id',
                'facebook_client_secret',
                'facebook_redirect_uri',
                'twitter_client_id',
                'twitter_client_secret',
                'twitter_redirect_uri',
                'payment_server_key',
                'payment_client_key',
                'is_production',
                'payment_type',
                'email_host',
                'email_port',
                'email_username',
                'email_password',
                'description'
            ]);
        });
    }
};
