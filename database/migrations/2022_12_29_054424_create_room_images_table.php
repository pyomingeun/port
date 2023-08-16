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
        //  Room iamges
        Schema::dropIfExists('room_images');
        Schema::create('room_images', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->integer('room_id')->default(0);
            $table->string('room_image', 250);
            $table->tinyInteger('is_featured')->default(0);
            $table->enum('status', array('draft','active','inactive', 'deleted'))->default('draft');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
        //
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
