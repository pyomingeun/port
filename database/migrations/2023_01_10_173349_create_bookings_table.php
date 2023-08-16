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
        // create booking table 
        Schema::dropIfExists('bookings');
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();
            $table->string('slug')->default('');
            $table->integer('hotel_id')->default(0);
            $table->integer('room_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->integer('is_rated')->default(0);
            $table->enum('status', array('active','inactive','deleted'))->default('active');
            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');
            $table->integer('no_of_nights')->default(0);
            $table->string('customer_full_name')->default('');
            $table->string('customer_phone')->default('');
            $table->string('customer_email')->default('');
            $table->integer('no_of_adults')->default(1);
            $table->integer('no_of_childs')->default(0);
            $table->integer('childs_plus_nyear')->default(0);
            $table->integer('childs_below_nyear')->default(0);
            $table->integer('no_of_extra_guest')->default(0);
            $table->text('child_ages');
            $table->longText('customer_notes');
            $table->longText('host_notes');
            $table->integer('per_night_charges')->default(0);
            $table->integer('weekday_price')->default(0);
            $table->integer('weekend_price')->default(0);
            $table->integer('peakseason_price')->default(0);
            $table->integer('no_of_weekdays')->default(0);
            $table->integer('no_of_weekenddays')->default(0);
            $table->integer('no_of_peakseason_days')->default(0);
            $table->integer('extra_guest_fee')->default(0);
            $table->integer('extra_guest_charges')->default(0);
            $table->integer('extra_service_charges')->default(0);
            $table->integer('sub_total')->default(0);
            $table->integer('total_price')->default(0);
            $table->integer('long_stay_discount_amount')->default(0);
            $table->string('coupon_code')->default('');
            $table->integer('coupon_discount_amount')->default(0);
            $table->integer('reward_points_used')->default(0);
            $table->integer('additonal_discount')->default(0);
            $table->integer('payment_by_cash')->default(0);
            $table->integer('payment_by_points')->default(0);
            $table->enum('booking_status', array('on_hold','confirmed','completed','cancelled','blocked'))->default('on_hold');
            $table->enum('payment_status', array('waiting','paid','pending','failed'))->default('waiting');
            $table->enum('payment_method', array('direct_bank_transfer','credit_card'));
            $table->tinyInteger('is_payout_generated')->default(0);
            $table->tinyInteger('is_points_sent')->default(0);
            $table->longText('cancellation_policy');
            $table->integer('canceled_by')->default(0);
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->integer('confirmed_by')->default(0);
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
        //
    }
};
