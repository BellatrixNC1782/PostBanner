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
        Schema::create('posters', function (Blueprint $table) {
            $table->id();
            $table->string('poster_name')->nullable();
            $table->string('poster_image')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });
        
        Schema::create('business_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('business_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('posters');
        Schema::dropIfExists('business_details');
    }
};
