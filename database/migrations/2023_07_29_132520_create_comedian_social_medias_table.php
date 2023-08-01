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
        Schema::create('comedian_social_medias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('comedian_id')->constrained('comedians');
            $table->string('name', 50)->nullable();
            $table->string('label', 50)->nullable();
            $table->string('url', 200)->nullable();
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
        Schema::dropIfExists('comedian_social_medias');
    }
};
