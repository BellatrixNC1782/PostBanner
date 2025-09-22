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
        Schema::create('festival', function (Blueprint $table) {
            $table->id();
            $table->string('county_code')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->date('date')->nullable();
            $table->longText('description')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival');
    }
};
