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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id');
            $table->timestamp('sales_period_start')->useCurrent();
            $table->timestamp('sales_period_end')->useCurrent();
            $table->timestamp('settlement_date')->useCurrent();
            $table->integer('sales_amount')->default('0');
            $table->integer('payble_amount')->default('0');
            $table->integer('no_of_bookings')->default('0');
            $table->enum('pay_status', array('planned','paid'))->default('planned');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('payouts');
    }
};
