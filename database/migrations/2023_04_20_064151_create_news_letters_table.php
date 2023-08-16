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
        Schema::dropIfExists('news_letter');
        Schema::create('news_letter', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default('0');
            $table->string('email', 250)->default('');
            $table->tinyInteger('is_subscribed')->default(0);
            $table->enum('status', array('active','inactive', 'deleted'))->default('active');
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
        Schema::dropIfExists('news_letter');
    }
};
