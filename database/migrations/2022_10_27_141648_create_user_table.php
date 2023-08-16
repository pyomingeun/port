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
        Schema::dropIfExists('user');
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 20);
            $table->string('email', 30);
            $table->string('phone', 15);
            $table->string('password', 100);
            $table->string('profile_pic', 250)->default(''); //nullable()
            $table->integer('hotel_id')->default(0);            
            $table->string('forgot_password_code', 100)->default('');
            $table->string('social_id', 250)->default(''); 
            $table->enum('signup_by', array('signupform', 'kakao', 'naver'))->default('signupform');
            $table->enum('access', array('admin', 'customer', 'hotel_manager', 'hotel_staff'))->default('customer');
            $table->enum('status', array('active','inactive', 'deleted'))->default('active');
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('set_password_code', 100)->default('');
            $table->string('change_email_verification_code', 100)->default('');
            $table->string('new_email_for_change', 30)->default('');
            $table->integer('total_rewards_points')->default(0);
            $table->tinyInteger('is_loging')->default(0); 
            $table->dateTime('last_activity_at')->nullable();
            $table->tinyInteger('agree_required')->default(0);
            $table->tinyInteger('agree_forever')->default(0);
            $table->tinyInteger('agree_message')->default(0);
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
