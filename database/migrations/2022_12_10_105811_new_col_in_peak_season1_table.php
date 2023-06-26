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
        Schema::table('hotel_peak_season', function (Blueprint $table) {
            //
            $table->dateTime('end_date')->nullable()->after('hotel_id');
            $table->dateTime('start_date')->nullable()->after('hotel_id');
            $table->string('season_name', 250)->default('')->after('hotel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_peak_season', function (Blueprint $table) {
            //
        });
    }
};
