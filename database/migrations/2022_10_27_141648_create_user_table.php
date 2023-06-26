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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 250);
            $table->string('email', 250);
            $table->string('phone', 250);
            $table->string('password', 250);
           // $table->string('profile_pic', 250)->default(''); //nullable()
           $table->string('profile_pic', 250)->default(''); 
        //    $table->integer('profile_setup_step')->default(0);
            $table->integer('hotel_id')->default(0);            
            $table->string('forgot_password_code', 250)->default('');
            $table->string('social_id', 250)->default(''); 
            $table->enum('signup_by', array('signupform', 'kakao', 'naver'))->default('signupform');
            $table->enum('access', array('admin', 'customer', 'hotel_manager', 'hotel_staff'))->default('customer');
            $table->enum('status', array('active','inactive', 'deleted'))->default('active');
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
        Schema::dropIfExists('user');
    }
};
