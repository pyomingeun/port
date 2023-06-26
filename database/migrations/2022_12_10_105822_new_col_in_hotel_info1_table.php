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
        Schema::table('hotel_info', function (Blueprint $table) {
            //
            $table->tinyInteger('completed_percentage')->default(0)->after('bank_detail_status');
            $table->tinyInteger('summary_status')->default(0)->after('bank_detail_status');
            $table->tinyInteger('other_info_status')->default(0)->after('bank_detail_status');
            $table->tinyInteger('fnf_status')->default(0)->after('bank_detail_status');
            $table->tinyInteger('hpolicies_status')->default(0)->after('bank_detail_status');
            $table->tinyInteger('address_status')->default(0)->after('bank_detail_status');
            $table->tinyInteger('basic_info_status')->default(0)->after('bank_detail_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_info', function (Blueprint $table) {
            //
            $table->tinyInteger('bank_detail_status')->default(0);
        });
    }
};
