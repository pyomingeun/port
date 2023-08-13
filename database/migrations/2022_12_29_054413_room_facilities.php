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
        // Room Facilities
        Schema::create('room_facilities', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->integer('room_id')->default(0);
            $table->integer('facilities_id')->default(0);
            $table->integer('hotel_facilities_id')->default(0);

            $table->timestamps(false);
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
