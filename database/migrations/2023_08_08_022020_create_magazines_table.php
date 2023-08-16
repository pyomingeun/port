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
        Schema::dropIfExists('magazines');
        Schema::create('magazines', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id');
            $table->string('magazine_title', 50);
            $table->string('contents',150);
            $table->string('cover_img',150);
            $table->string('banner_img',150);
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
        Schema::dropIfExists('magazines');
    }
};
