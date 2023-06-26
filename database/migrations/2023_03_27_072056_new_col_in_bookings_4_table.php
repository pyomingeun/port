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
        Schema::table('bookings', function (Blueprint $table) {
            //
            $table->integer('childs_plus_nyear')->default(0)->after('no_of_childs');
            $table->integer('childs_below_nyear')->default(0)->after('no_of_childs');
            $table->integer('no_of_peakseason_days')->default(0)->after('per_night_charges');
            $table->integer('no_of_weekenddays')->default(0)->after('per_night_charges');
            $table->integer('no_of_weekdays')->default(0)->after('per_night_charges');
            $table->double('extra_guest_fee', 10, 2)->default(0)->after('extra_guest_charges');
            $table->double('weekday_price', 10, 2)->default(0)->after('per_night_charges');
            $table->double('weekend_price', 10, 2)->default(0)->after('per_night_charges');
            $table->double('peakseason_price', 10, 2)->default(0)->after('per_night_charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
