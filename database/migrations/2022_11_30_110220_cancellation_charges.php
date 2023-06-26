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
         // Cancellation Charges
        Schema::create('cancellation_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->double('same_day_refund', 8, 2)->default(0);
            $table->double('b4_1day_refund', 8, 2)->default(0);
            $table->double('b4_2days_refund', 8, 2)->default(0);
            $table->double('b4_3days_refund', 8, 2)->default(0);
            $table->double('b4_4days_refund', 8, 2)->default(0);
            $table->double('b4_5days_refund', 8, 2)->default(0);
            $table->double('b4_6days_refund', 8, 2)->default(0);
            $table->double('b4_7days_refund', 8, 2)->default(0);
            $table->double('b4_8days_refund', 8, 2)->default(0);
            $table->double('b4_9days_refund', 8, 2)->default(0);
            $table->double('b4_10days_refund', 8, 2)->default(0);
            $table->enum('status', array('draft','active','inactive', 'deleted'))->default('draft');
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
        //
    }
};
