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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email', 191)->unique();
            $table->string('new_email')->nullable();
            $table->string('email_token')->nullable();
            $table->string('number', 191)->unique();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->integer('msg_otp')->nullable();
            $table->timestamp('otp_expire_time')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
        
        DB::table('admins')->insert(
            array(
                'role' => 'Admin',
                'first_name' => "banner",
                'last_name' => 'Admin',
                'email' => 'support@mailinator.com',
                'number' => '1563247890',
                'password' => bcrypt('Admin@123'),
            )
        );
        
        DB::table('admins')->insert(
            array(
                'role' => 'Super Admin',
                'first_name' => "banner",
                'last_name' => 'Super Admin',
                'email' => 'banner@mailinator.com',
                'number' => '1234567890',
                'password' => bcrypt('Admin@123'),
            )
        ); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
