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
        Schema::dropIfExists('reward_history');
        Schema::create('reward_history', function (Blueprint $table) {
            $table->id();
            $table->string('slug',250);
            $table->integer('user_id')->default(0);
            $table->string('booking_slug')->default('');
            $table->string('title', 250);
            $table->string('message', 250);
            $table->integer('reward_points')->default(0);
            $table->integer('remaing_points')->default(0);
            $table->enum('reward_type', array('debited','credited'));
            $table->timestamp('transaction_on')->useCurrent();
            $table->enum('status', array('active','pending','deleted'))->default('active');
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
