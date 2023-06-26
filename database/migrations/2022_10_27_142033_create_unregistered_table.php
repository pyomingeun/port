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
        Schema::create('unregistered', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 250);
            $table->string('email', 250);
            $table->string('phone', 250);
            $table->string('password', 250);
            $table->string('activation_code', 250); 
            $table->enum('access', array('admin', 'customer', 'hotel_manager', 'hotel_staff'))->default('customer');
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
        Schema::dropIfExists('unregistered');
    }
};
