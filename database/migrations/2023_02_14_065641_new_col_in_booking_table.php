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
            $table->double('extra_services_charges', 10, 2)->default(0);
            $table->double('sub_total', 10, 2)->default(0);
            $table->double('total_price', 10, 2)->default(0);
            $table->longText('cancellation_policy')->default('');
            $table->integer('cancelled_by')->default(0);
            $table->timestamp('cancelled_at')->nullable();
            $table->integer('confirmed_by')->default(0);
            $table->timestamp('confirmed_at')->nullable();
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
