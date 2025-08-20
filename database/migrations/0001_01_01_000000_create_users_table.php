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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('new_email')->nullable();
            $table->enum('new_email_verify', ['Yes', 'No'])->default('No');
            $table->string('mobile')->nullable();
            $table->integer('email_otp')->nullable();
            $table->timestamp('email_otp_expire')->nullable();
            $table->enum('email_verify', ['Yes', 'No'])->default('Yes');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('push_notify', ['Yes', 'No'])->default('Yes');
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->longText('revoke_access_token')->nullable();
            $table->string('uu_id')->nullable();
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_os')->nullable();
            $table->string('app_version')->nullable();
            $table->string('api_version')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_name')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
        Schema::create('user_device_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('device_token')->nullable();
            $table->string('uu_id')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_os')->nullable();
            $table->string('app_version')->nullable();
            $table->string('api_version')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_name')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_device_tokens');
    }
};
