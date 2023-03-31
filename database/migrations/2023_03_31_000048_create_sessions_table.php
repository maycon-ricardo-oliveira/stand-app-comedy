<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('attraction_id')->constrained('attractions');
            $table->string('session_code');
            $table->integer('tickets')->default(0);
            $table->integer('tickets_sold')->default(0);
            $table->integer('tickets_validated')->default(0);
            $table->time('start_at')->nullable();
            $table->time('finish_at')->nullable();
            $table->enum('status', ['draft', 'published', 'validating', 'active', 'finish']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
