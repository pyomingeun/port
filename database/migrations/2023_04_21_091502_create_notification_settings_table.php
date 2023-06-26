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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->tinyInteger('booking_on_hold_email')->default(0);
            $table->tinyInteger('booking_confirmed_email')->default(0);
            $table->tinyInteger('booking_completed_email')->default(0);
            $table->tinyInteger('booking_cancelled_email')->default(0);
            $table->tinyInteger('booking_refund_email')->default(0);
            $table->tinyInteger('booking_on_hold_sms')->default(0);
            $table->tinyInteger('booking_confirmed_sms')->default(0);
            $table->tinyInteger('booking_completed_sms')->default(0);
            $table->tinyInteger('booking_cancelled_sms')->default(0);
            $table->tinyInteger('booking_refund_sms')->default(0);
            $table->enum('status', array('active','inactive', 'deleted'))->default('active');
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
        Schema::dropIfExists('notification_settings');
    }
};
