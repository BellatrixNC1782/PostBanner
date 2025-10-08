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
        Schema::table('users', function (Blueprint $table) {
            $table->after('30_day_notify', function ($table) {
                $table->enum('welcome_notify', ['Yes', 'No'])->default('No');
            });
        });
        
        Schema::table('user_device_tokens', function (Blueprint $table) {
            $table->after('30_day_notify', function ($table) {
                $table->enum('welcome_notify', ['Yes', 'No'])->default('No');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('welcome_notify');
        });
        Schema::table('user_device_tokens', function (Blueprint $table) {
            $table->dropColumn('welcome_notify');
        });
    }
};
