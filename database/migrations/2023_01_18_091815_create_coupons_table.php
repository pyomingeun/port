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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('slug',250);
            $table->integer('hotel_id')->default(0);
            $table->string('coupon_code_name', 250);
            $table->enum('discount_type', array('fixed_amount','percentage'))->default('percentage');
            $table->double('discount_amount', 10, 2)->default(0);
            $table->double('max_discount_amount', 10, 2)->default(0);
            $table->dateTime('expiry_date')->nullable();
            $table->integer('limit_per_user')->default(0);
            $table->integer('available_no_of_coupon_to_use')->default(0);
            $table->integer('no_of_coupon_used')->default(0);
            $table->enum('status', array('active','expired','deleted'))->default('active');
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
        Schema::dropIfExists('coupons');
    }
};
