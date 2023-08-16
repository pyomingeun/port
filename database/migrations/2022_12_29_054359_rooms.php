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
        //
        // create rooms table 
        Schema::dropIfExists('rooms');
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->default('');
            $table->integer('hotel_id')->default(0);
            $table->string('room_name', 50)->default('');
            $table->string('room_size', 10)->default('');
            $table->integer('no_of_bathrooms')->default(0);
            $table->string('room_featured_img', 250)->default('');
            $table->longText('room_description');
            $table->integer('standard_occupancy')->default(0);
            $table->integer('maximum_occupancy')->default(0);
            $table->integer('freechild_occupancy')->default(0);
            $table->double('standard_price_weekday', 10, 2)->default(0);
            $table->double('standard_price_weekend', 10, 2)->default(0);
            $table->double('standard_price_peakseason', 10, 2)->default(0);
            $table->double('extra_guest_fee', 10, 2)->default(0);
            $table->tinyInteger('basic_info_status')->default(0);
            $table->tinyInteger('beds_status')->default(0);
            $table->tinyInteger('roomfnf_status')->default(0);
            $table->tinyInteger('pricing_status')->default(0);
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
