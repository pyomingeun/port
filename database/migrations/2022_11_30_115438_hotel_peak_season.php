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
        // Hotel Peak Season
        Schema::dropIfExists('hotel_peak_season');
        Schema::create('hotel_peak_season', function (Blueprint $table) {
            $table->id();
            $table->string('season_name', 250)->default('');
            $table->integer('hotel_id')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
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
