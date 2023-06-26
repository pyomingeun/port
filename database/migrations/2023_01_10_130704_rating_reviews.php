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
        // create my favorites table 
        Schema::create('rating_reviews', function (Blueprint $table) {

            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->integer('booking_id')->default(0);
            $table->integer('cleanliness')->default(0);
            $table->integer('facilities')->default(0);
            $table->integer('service')->default(0);
            $table->integer('value_for_money')->default(0);
            $table->text('review')->default('');
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
