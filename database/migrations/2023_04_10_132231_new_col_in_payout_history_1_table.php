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
        Schema::table('payout_history', function (Blueprint $table) {
            //
            $table->integer('sales_amount')->default('0')->after('commission');
            $table->integer('payble_amount')->default('0')->after('commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payout_history', function (Blueprint $table) {
            //
        });
    }
};
