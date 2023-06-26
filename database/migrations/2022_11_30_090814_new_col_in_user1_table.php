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
        Schema::table('user', function (Blueprint $table) {
            //
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('set_password_code', 250)->default('');
            $table->string('change_email_verification_code', 250)->default('');
            $table->string('new_email_for_change', 250)->default('');
            $table->integer('total_rewards_points')->default(0);
            $table->tinyInteger('is_loging')->default(0); 
            $table->dateTime('last_activity_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
};
