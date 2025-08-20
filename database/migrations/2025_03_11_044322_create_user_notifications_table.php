<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('from_id')->nullable();
            $table->integer('send_id')->nullable();
            $table->integer('redirection_id')->nullable();
            $table->longText('message_test')->nullable();
            $table->integer('is_read')->default(0);
            $table->string('display_type')->nullable();
            $table->integer('display_flag')->default(0);
            $table->string('redirect_key')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notifications');
    }
}
