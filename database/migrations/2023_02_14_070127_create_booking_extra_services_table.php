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
        Schema::dropIfExists('booking_extra_services');
        Schema::create('booking_extra_services', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->default(0);
            $table->integer('es_id')->default(0);
            $table->double('price', 10, 2)->default(0);  
            $table->integer('qty')->default(0);
            $table->double('es_row_total', 10, 2)->default(0);  
            $table->enum('status', array('active','inactive','deleted'))->default('active');
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
        Schema::dropIfExists('booking_extra_services');
    }
};
