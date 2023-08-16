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
        // Room Features
        Schema::dropIfExists('room_features');
        Schema::create('room_features', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->integer('room_id')->default(0);
            $table->integer('features_id')->default(0);
            $table->integer('hotel_features_id')->default(0);
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
