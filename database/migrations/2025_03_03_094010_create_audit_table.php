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
        $connection = config('audit.drivers.database.connection', config('database.default'));
        $table = config('audit.drivers.database.table', 'audits');

        Schema::connection($connection)->create($table, function (Blueprint $table) {
            $morphPrefix = config('audit.user.morph_prefix', 'user');

            $table->bigIncrements('id');
            
            // Limit user_type length to 191 characters
            $table->string($morphPrefix . '_type', 191)->nullable();
            $table->unsignedBigInteger($morphPrefix . '_id')->nullable();
            $table->string('event');
            
            // Define morphs manually with limited string length
            $table->string('auditable_type', 191);
            $table->unsignedBigInteger('auditable_id');

            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 1023)->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();

            // Fix indexing issue by ensuring 'user_type' is within size limit
            $table->index([$morphPrefix . '_id', $morphPrefix . '_type']);
            $table->index(['auditable_type', 'auditable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('audit.drivers.database.connection', config('database.default'));
        $table = config('audit.drivers.database.table', 'audits');

        Schema::connection($connection)->drop($table);
    }
};
