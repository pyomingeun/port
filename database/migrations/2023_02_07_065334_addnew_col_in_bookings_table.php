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
        Schema::table('bookings', function (Blueprint $table) {
            //
            $table->string('slug')->default('')->after('id');
            $table->dateTime('check_in_date')->nullable();
            $table->dateTime('check_out_date')->nullable();
            $table->string('customer_full_name')->default('');
            $table->string('customer_phone')->default('');
            $table->string('customer_email')->default('');
            $table->integer('no_of_adults')->default(0);
            $table->integer('no_of_childs')->default(0);
            $table->integer('no_of_extra_guest')->default(0);
            $table->integer('no_of_nights')->default(0);
            $table->text('child_ages')->default('');
            $table->longText('customer_notes')->default('');
            $table->longText('host_notes')->default('');
            $table->double('per_night_charges', 10, 2)->default(0);
            $table->double('extra_guest_charges', 10, 2)->default(0);
            $table->double('long_stay_discount_amount', 10, 2)->default(0);
            $table->string('coupon_code')->default('');
            $table->double('coupon_discount_amount', 10, 2)->default(0);
            $table->integer('reward_points_used')->default(0);
            $table->double('payment_by_currency', 10, 2)->default(0);
            $table->double('payment_by_points', 10, 2)->default(0);
            $table->enum('booking_status', array('on_hold','confirmed','completed','cancelled','blocked'))->default('on_hold');
            $table->enum('payment_status', array('waiting','paid','pending','failed'))->default('waiting');
            $table->enum('payment_method', array('direct_bank_transfer','credit_card'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
