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
        Schema::table('saved_posters', function (Blueprint $table) {
            $table->after('poster_json', function ($table) {
                $table->enum('is_notify', ['Yes', 'No'])->default('No');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saved_posters', function (Blueprint $table) {
            $table->dropColumn('is_notify');
        });
    }
};
