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
        // hotel manager bank details 
        Schema::dropIfExists('bank_ac_details');
        Schema::create('bank_ac_details', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->string('account_num', 250);
            $table->string('bank_name', 250);
            $table->string('ac_holder_name', 250);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
        //
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
