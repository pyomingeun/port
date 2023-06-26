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
        // hotel basic info
        Schema::create('hotel_info', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->string('hotel_name', 250);
            $table->string('logo', 250)->default('');;
            $table->string('featured_img', 250)->default('');
            $table->longText('description')->default('');
            $table->string('latitude', 250)->default('');
            $table->string('longitude', 250)->default('');
            $table->text('street')->default('');
            $table->string('city', 250)->default('');
            $table->string('pincode', 250)->default('');
            $table->text('subrub')->default('');
            $table->string('check_in', 250)->default('');
            $table->string('check_out', 250)->default('');
            $table->longText('hotel_policy', 250)->default('');
            $table->longText('terms_and_conditions', 250)->default('');
            $table->integer('rating')->default(0);
            $table->tinyInteger('bank_detail_status')->default(0);
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
