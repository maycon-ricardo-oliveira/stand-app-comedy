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
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ticket_id')->constrained('tickets')->nullable();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('payment_gateway_id')->constrained('payment_gateways');
            $table->foreignUuid('payment_profile_id')->constrained('payment_profiles');
            $table->double('price', 10, 2)->nullable();
            $table->string('external_id')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->enum('status', ['received', 'processing_payment', 'paid', 'processing', 'canceled']);
            $table->string('src');
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
        Schema::dropIfExists('purchases');
    }
};
