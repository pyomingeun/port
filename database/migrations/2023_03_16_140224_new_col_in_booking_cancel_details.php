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
            $table->string('account_holder_name')->default('')->after('total_refund_amount');  
            $table->string('account_number')->default('')->after('total_refund_amount');  
            $table->string('iban_code')->default('')->after('total_refund_amount');  
            $table->string('bank_name')->default('')->after('total_refund_amount');  
            $table->integer('refund_points')->default(0)->after('total_refund_amount');  
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
