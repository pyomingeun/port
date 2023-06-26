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
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();
            $table->integer('slug')->default(0);
            $table->integer('hotel_id')->default(0);
            $table->integer('room_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('is_rated')->default(0);
            $table->enum('status', array('active','inactive','deleted'))->default('active');
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
