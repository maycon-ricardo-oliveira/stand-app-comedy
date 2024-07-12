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
        Schema::create('banner_metas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('banner_id')->constrained('banners');
            $table->string('name', 100)->nullable();
            $table->string('value', 200)->nullable();
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
        Schema::dropIfExists('banner_metas');
    }
};
