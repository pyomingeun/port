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
        // Room Beds
        Schema::dropIfExists('room_beds');
        Schema::create('room_beds', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->integer('room_id')->default(0);
            $table->string('bed_type', 250)->default('');
            $table->integer('bed_qty')->default(0);
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
