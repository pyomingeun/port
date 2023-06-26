<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voterms_and_conditions
     */
    public function up()
    {
        Schema::table('hotel_info', function (Blueprint $table) {
            //
            $table->double('b4_10days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_9days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_8days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_7days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_6days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_5days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_4days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_3days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_2days_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('b4_1day_refund', 8, 2)->default(0)->after('terms_and_conditions');
            $table->double('same_day_refund', 8, 2)->default(0)->after('terms_and_conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voterms_and_conditions
     */
    public function down()
    {
        Schema::table('hotel_info', function (Blueprint $table) {
            //
        });
    }
};
