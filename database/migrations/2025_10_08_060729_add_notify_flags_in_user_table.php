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
            $table->after('push_notify', function ($table) {
                $table->enum('7_day_notify', ['Yes', 'No'])->default('No');
                $table->enum('15_day_notify', ['Yes', 'No'])->default('No');
                $table->enum('30_day_notify', ['Yes', 'No'])->default('No');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('7_day_notify');
            $table->dropColumn('15_day_notify');
            $table->dropColumn('30_day_notify');
        });
    }
};
