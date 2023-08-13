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
        Schema::create('booking_cancel_details', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->default(0);
            $table->integer('refund_amount_in_points')->default(0);
            $table->double('refund_amount_in_money', 10, 2)->default(0);  
            $table->double('total_refund_amount', 10, 2)->default(0);  
            $table->integer('refund_points')->default(0);  
            $table->text('cancellation_reason')->default('');
            $table->text('adjusted_reason')->default('');
            $table->integer('refund_percentage')->default(0);
            $table->integer('cancellation_before_n_days')->default(0);
            $table->string('bank_name')->default('');  
            $table->string('iban_code')->default('');  
            $table->string('account_holder_name')->default('');
            $table->string('account_number')->default('');
            $table->enum('refund_status', array('refund_pending','refunded','no_refund'));
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
        Schema::dropIfExists('booking_cancel_details');
    }
};
