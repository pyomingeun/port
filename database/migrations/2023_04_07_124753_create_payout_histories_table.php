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
        Schema::create('payout_history', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id');
            $table->integer('payout_id');
            $table->integer('booking_id');
            $table->integer('commission_rate');
            $table->integer('commission');
            $table->integer('sales_amount')->default('0');
            $table->integer('payble_amount')->default('0');
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
        Schema::dropIfExists('payout_history');
    }
};
