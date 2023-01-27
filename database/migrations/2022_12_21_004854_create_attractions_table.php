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
        Schema::create('attractions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->dateTime('date');
            $table->string('duration');
            $table->enum('status', ['draft', 'published', 'finish']);

            $table->foreignUuid('comedian_id')->constrained('comedians');
            $table->foreignUuid('place_id')->constrained('places');
            $table->foreignUuid('owner_id')->constrained('users');

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
        Schema::dropIfExists('attractions');
    }
};
