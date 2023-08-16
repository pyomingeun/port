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
        // Near By Tourist Attractions
        Schema::dropIfExists('nearest_tourist_attractions');
        Schema::create('nearest_tourist_attractions', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->string('attractions_name', 250);
            $table->string('nta_address', 250);
            $table->string('nta_latitude', 250)->default('');
            $table->string('nta_longitude', 250)->default('');
            $table->longText('nta_description');
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
