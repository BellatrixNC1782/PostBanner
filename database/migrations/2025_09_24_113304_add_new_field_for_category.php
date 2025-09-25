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
        Schema::table('categories', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('county_code')->nullable();
                $table->string('image')->nullable();
                $table->date('date')->nullable();
            });
        });

        Schema::dropIfExists('festival');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('county_code');
            $table->dropColumn('image');
            $table->dropColumn('date');
        });
    }
};
