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
        Schema::table('booking_cancel_details', function (Blueprint $table) {
            //
            $table->integer('cancellation_before_n_days')->default(0)->after('refund_points');
            $table->integer('refund_percentage')->default(0)->after('refund_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_cancel_details', function (Blueprint $table) {
            //
        });
    }
};
